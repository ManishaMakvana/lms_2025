<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KitActivationCode;
use App\Models\TinkeringModule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KitCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kitCodes = KitActivationCode::with(['module', 'generatedBy', 'usedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Statistics
        $totalCodes = KitActivationCode::count();
        $usedCodes = KitActivationCode::where('status', 'used')->count();
        $availableCodes = KitActivationCode::where('status', 'unused')->count();
        $blockedCodes = KitActivationCode::where('status', 'blocked')->count();

        return view('admin.kit-codes.index', compact('kitCodes', 'totalCodes', 'usedCodes', 'availableCodes', 'blockedCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = TinkeringModule::where('is_active', true)->get();
        return view('admin.kit-codes.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:tinkering_modules,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $module = TinkeringModule::find($validated['module_id']);
        $generatedCodes = [];

        // Generate the specified quantity of 6-digit codes
        for ($i = 0; $i < $validated['quantity']; $i++) {
            $code = $this->generateUniqueCode();
            
            $kitCode = KitActivationCode::create([
                'code' => $code,
                'module_id' => $validated['module_id'],
                'status' => 'unused',
                'generated_by' => auth()->id(),
            ]);

            $generatedCodes[] = $kitCode;
        }

        return redirect()->route('admin.kit-codes.index')
            ->with('success', "Successfully generated {$validated['quantity']} kit codes for {$module->module_name}!");
    }

    /**
     * Generate multiple codes for a module
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:tinkering_modules,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $module = TinkeringModule::find($validated['module_id']);
        $generatedCodes = [];

        // Generate the specified quantity of 6-digit codes
        for ($i = 0; $i < $validated['quantity']; $i++) {
            $code = $this->generateUniqueCode();
            
            $kitCode = KitActivationCode::create([
                'code' => $code,
                'module_id' => $validated['module_id'],
                'status' => 'unused',
                'generated_by' => auth()->id(),
            ]);

            $generatedCodes[] = $kitCode;
        }

        return redirect()->route('admin.kit-codes.index')
            ->with('success', "Successfully generated {$validated['quantity']} kit codes for {$module->module_name}!");
    }

    /**
     * Display the specified resource.
     */
    public function show(KitActivationCode $kitCode)
    {
        $kitCode->load(['module', 'generatedBy', 'usedBy']);
        return view('admin.kit-codes.show', compact('kitCode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KitActivationCode $kitCode)
    {
        $modules = TinkeringModule::where('is_active', true)->get();
        return view('admin.kit-codes.edit', compact('kitCode', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KitActivationCode $kitCode)
    {
        $validated = $request->validate([
            'status' => 'required|in:unused,used,blocked',
            'module_id' => 'required|exists:tinkering_modules,id',
        ]);

        $kitCode->update($validated);

        return redirect()->route('admin.kit-codes.index')
            ->with('success', 'Kit code updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KitActivationCode $kitCode)
    {
        $kitCode->delete();

        return redirect()->route('admin.kit-codes.index')
            ->with('success', 'Kit code deleted successfully.');
    }

    /**
     * Bulk delete kit codes
     */
    public function bulkDelete(Request $request)
    {
        \Log::info('Bulk delete request received', [
            'method' => $request->method(),
            'url' => $request->url(),
            'data' => $request->all()
        ]);

        try {
            $validated = $request->validate([
                'kit_code_ids' => 'required|string',
            ]);

            $kitCodeIds = json_decode($validated['kit_code_ids'], true);
            
            if (!is_array($kitCodeIds) || empty($kitCodeIds)) {
                return redirect()->route('admin.kit-codes.index')
                    ->with('error', 'No valid kit codes selected for deletion.');
            }

            // Validate that all IDs are integers
            $kitCodeIds = array_filter($kitCodeIds, function($id) {
                return is_numeric($id) && (int)$id > 0;
            });

            if (empty($kitCodeIds)) {
                return redirect()->route('admin.kit-codes.index')
                    ->with('error', 'No valid kit code IDs provided.');
            }

            $deletedCount = KitActivationCode::whereIn('id', $kitCodeIds)->delete();

            if ($deletedCount > 0) {
                return redirect()->route('admin.kit-codes.index')
                    ->with('success', "Successfully deleted {$deletedCount} kit code(s).");
            } else {
                return redirect()->route('admin.kit-codes.index')
                    ->with('error', 'No kit codes were found to delete.');
            }
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.kit-codes.index')
                ->with('error', 'Invalid request data: ' . implode(', ', $e->validator->errors()->all()));
        } catch (\Exception $e) {
            \Log::error('Bulk delete kit codes error: ' . $e->getMessage());
            return redirect()->route('admin.kit-codes.index')
                ->with('error', 'An error occurred while deleting the kit codes. Please try again.');
        }
    }

    /**
     * Export kit codes to CSV
     */
    public function export()
    {
        $kitCodes = KitActivationCode::with(['module', 'generatedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'kit-codes-' . now()->format('Y-m-d-H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($kitCodes) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, ['Code', 'Module', 'Status', 'Generated By', 'Generated At', 'Used By', 'Used At']);
            
            // CSV Data
            foreach ($kitCodes as $kitCode) {
                fputcsv($file, [
                    $kitCode->code,
                    $kitCode->module->module_name ?? 'N/A',
                    ucfirst($kitCode->status),
                    $kitCode->generatedBy->name ?? 'N/A',
                    $kitCode->created_at->format('Y-m-d H:i:s'),
                    $kitCode->usedBy->name ?? 'N/A',
                    $kitCode->used_at ? $kitCode->used_at->format('Y-m-d H:i:s') : 'N/A',
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate a unique 6-digit code
     */
    private function generateUniqueCode()
    {
        do {
            // Generate a 6-digit code with letters and numbers
            $code = strtoupper(Str::random(6));
        } while (KitActivationCode::where('code', $code)->exists());

        return $code;
    }
}
