<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RedeemCodeRequest;
use App\Models\KitActivationCode;
use App\Models\ModuleUser;
use App\Models\TinkeringModule;
use App\Models\TinkeringModuleSubActivity;
use App\Models\UserActivityProgress;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of modules
     */
    public function index()
    {
        $user = auth()->user();
        
        $modules = TinkeringModule::where('is_active', true)
            ->with(['subActivities'])
            ->get();
        
        // Get user's unlocked module IDs
        $unlockedModuleIds = $user->unlockedModules()
            ->where('module_user.is_active', true)
            ->pluck('tinkering_modules.id')
            ->toArray();
        
        return view('user.modules.index', compact('modules', 'unlockedModuleIds'));
    }

    /**
     * Display the specified module
     */
    public function show(TinkeringModule $module)
    {
        $user = auth()->user();
        
        // Check if user has access to this module
        $hasAccess = $user->unlockedModules()->where('tinkering_modules.id', $module->id)->exists();
        
        if (!$hasAccess) {
            return view('user.modules.locked', compact('module'));
        }
        
        $module->load(['subActivities' => function($query) {
            $query->where('is_active', true)->orderBy('order');
        }]);
        
        return view('user.modules.show', compact('module'));
    }

    /**
     * Display the specified sub-activity
     */
    public function showActivity(TinkeringModule $module, TinkeringModuleSubActivity $activity)
    {
        $user = auth()->user();
        
        // Check if user has access to this module
        $hasAccess = $user->unlockedModules()->where('tinkering_modules.id', $module->id)->exists();
        
        if (!$hasAccess) {
            abort(403, 'You do not have access to this module.');
        }
        
        $activity->load(['checklists' => function($query) {
            $query->orderBy('order');
        }]);
        
        // Get or create user progress
        $progress = UserActivityProgress::firstOrCreate([
            'user_id' => $user->id,
            'sub_activity_id' => $activity->id,
        ]);
        
        return view('user.activities.show', compact('module', 'activity', 'progress'));
    }

    /**
     * Show the redeem code form
     */
    public function showRedeemForm(TinkeringModule $module)
    {
        return view('user.modules.redeem', compact('module'));
    }

    /**
     * Redeem activation code for a module
     */
    public function redeemCode(RedeemCodeRequest $request, TinkeringModule $module)
    {
        try {
            $user = auth()->user();
            $code = $request->validated()['full_code'];
            
            $kitCode = KitActivationCode::where('code', $code)->first();
            
            if (!$kitCode) {
                return back()->withErrors(['code' => 'Invalid activation code.']);
            }
            
            // Mark code as used
            $kitCode->markAsUsed($user);
            
            // Create module access record
            ModuleUser::create([
                'user_id' => $user->id,
                'module_id' => $module->id,
                'activation_code_id' => $kitCode->id,
                'unlocked_at' => now(),
                'is_active' => true,
            ]);
            
            return redirect()->route('modules.show', $module)
                ->with('success', 'Module unlocked successfully!');
                
        } catch (\Exception $e) {
            \Log::error('Redeem code error: ' . $e->getMessage());
            return back()->withErrors(['code' => 'An error occurred while redeeming the code.']);
        }
    }

    /**
     * Toggle checklist item completion
     */
    public function toggleChecklist(Request $request, TinkeringModuleSubActivity $activity, $checklistId)
    {
        try {
            $user = auth()->user();
            
            \Log::info('Checklist toggle request', [
                'user_id' => $user->id,
                'activity_id' => $activity->id,
                'checklist_id' => $checklistId,
                'request_data' => $request->all()
            ]);
        
        // Get or create user progress
        $progress = UserActivityProgress::firstOrCreate([
            'user_id' => $user->id,
            'sub_activity_id' => $activity->id,
        ]);
        
        $completedItems = $progress->completed_checklist_items ?? [];
        
        if (in_array($checklistId, $completedItems)) {
            // Remove from completed items
            $completedItems = array_diff($completedItems, [$checklistId]);
        } else {
            // Add to completed items
            $completedItems[] = $checklistId;
        }
        
        // Get total checklist items for this activity
        $totalItems = $activity->checklists()->count();
        
        // Update progress
        $progress->updateProgress($completedItems, $totalItems);
        
        // Refresh the progress to get updated values
        $progress->refresh();
        
        \Log::info('Checklist toggle', [
            'user_id' => $user->id,
            'activity_id' => $activity->id,
            'checklist_id' => $checklistId,
            'completed_items' => $completedItems,
            'progress_percent' => $progress->progress_percent,
            'total_items' => $totalItems
        ]);
        
            // Redirect back with success message
            return redirect()->back()->with('success', 'Checklist updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Checklist toggle error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Error updating checklist: ' . $e->getMessage());
        }
    }

    /**
     * Save progress for multiple checklist items
     */
    public function saveProgress(Request $request, TinkeringModuleSubActivity $activity)
    {
        try {
            // Simple validation
            if (!auth()->check()) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }
            
            $user = auth()->user();
            
            // Get completed items from request
            $completedItemsJson = $request->input('completed_items', '[]');
            $completedItems = json_decode($completedItemsJson, true) ?? [];
            
            // Ensure completed items are integers
            $completedItems = array_map('intval', array_filter($completedItems));
            
            // Get total checklist items for this activity
            $totalItems = $activity->checklists()->count();
            
            // Get or create user progress
            $progress = UserActivityProgress::firstOrCreate([
                'user_id' => $user->id,
                'sub_activity_id' => $activity->id,
            ], [
                'completed_checklist_items' => [],
                'progress_percent' => 0,
                'last_viewed_at' => now(),
            ]);
            
            // Calculate progress percent
            $progressPercent = $totalItems > 0 ? (count($completedItems) / $totalItems) * 100 : 0;
            
            // Update progress manually instead of using the method
            $progress->update([
                'completed_checklist_items' => $completedItems,
                'progress_percent' => round($progressPercent, 2),
                'last_viewed_at' => now(),
            ]);
            
            $progress->refresh();
            
            return response()->json([
                'success' => true,
                'progress_percent' => (float) $progress->progress_percent,
                'completed_count' => count($completedItems),
                'total_count' => $totalItems,
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Save progress error: ' . $e->getMessage(), [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'activity_id' => $activity->id ?? 'null',
                'user_id' => auth()->id() ?? 'null',
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while saving progress',
                'message' => config('app.debug') ? $e->getMessage() : 'Server error'
            ], 500);
        }
    }
}
