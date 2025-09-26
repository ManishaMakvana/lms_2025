<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TinkeringModule;
use App\Models\UserActivityProgress;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get active modules
        $activeModules = TinkeringModule::where('is_active', true)
            ->with(['subActivities'])
            ->get();
        
        // Get user's unlocked module IDs
        $unlockedModuleIds = $user->unlockedModules()
            ->where('module_user.is_active', true)
            ->pluck('tinkering_modules.id')
            ->toArray();
        
        // Calculate progress for each unlocked module
        $moduleProgress = $this->calculateModuleProgress($user, $unlockedModuleIds);
        
        return view('user.dashboard', compact('activeModules', 'unlockedModuleIds', 'moduleProgress'));
    }
    
    /**
     * Calculate progress for each unlocked module
     */
    private function calculateModuleProgress($user, $unlockedModuleIds)
    {
        $moduleProgress = [];
        
        if (empty($unlockedModuleIds)) {
            return $moduleProgress;
        }
        
        foreach ($unlockedModuleIds as $moduleId) {
            $module = TinkeringModule::find($moduleId);
            if ($module) {
                $activities = $module->subActivities()->where('is_active', true)->get();
                $totalActivities = $activities->count();
                $completedActivities = 0;
                
                foreach ($activities as $activity) {
                    $progress = UserActivityProgress::where('user_id', $user->id)
                        ->where('sub_activity_id', $activity->id)
                        ->first();
                    
                    if ($progress && $progress->progress_percent >= 100) {
                        $completedActivities++;
                    }
                }
                
                $progressPercent = $totalActivities > 0 ? round(($completedActivities / $totalActivities) * 100, 1) : 0;
                $allCompleted = $totalActivities > 0 && $completedActivities >= $totalActivities;
                
                $moduleProgress[] = [
                    'module_id' => $module->id,
                    'module_name' => $module->module_name,
                    'module_slug' => $module->slug,
                    'total_activities' => $totalActivities,
                    'completed_activities' => $completedActivities,
                    'progress_percent' => $progressPercent,
                    'all_completed' => $allCompleted
                ];
            }
        }
        
        return $moduleProgress;
    }
}
