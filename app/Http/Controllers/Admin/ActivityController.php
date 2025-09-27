<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityChecklist;
use App\Models\TinkeringModule;
use App\Models\TinkeringModuleSubActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = TinkeringModuleSubActivity::with(['module'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = TinkeringModule::where('is_active', true)->get();
        return view('admin.activities.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tinkering_module_id' => 'required|exists:tinkering_modules,id',
            'title' => 'required|string|max:255',
            'objective' => 'required|string',
            'concept_focus' => 'required|string',
            'materials_needed' => 'required|array|min:1',
            'materials_needed.*' => 'required|string|max:255',
            'instructions' => 'required|string',
            'circuit_diagram' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'explanation' => 'required|string',
            'video_link' => 'nullable|url',
            'is_active' => 'boolean',
            'checklist_items' => 'nullable|array',
            'checklist_items.*.item' => 'required_with:checklist_items|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        // Handle circuit diagram upload
        if ($request->hasFile('circuit_diagram')) {
            $validated['circuit_diagram'] = $request->file('circuit_diagram')->store('circuit-diagrams', 'public');
        }

        $activity = TinkeringModuleSubActivity::create($validated);

        // Create checklist items if provided
        if ($request->has('checklist_items')) {
            foreach ($request->checklist_items as $checklistData) {
                if (!empty($checklistData['item'])) {
                    ActivityChecklist::create([
                        'tinkering_module_sub_activity_id' => $activity->id,
                        'item' => $checklistData['item'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TinkeringModuleSubActivity $activity)
    {
        $activity->load(['module', 'checklists']);
        
        return view('admin.activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TinkeringModuleSubActivity $activity)
    {
        $modules = TinkeringModule::where('is_active', true)->get();
        return view('admin.activities.edit', compact('activity', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TinkeringModuleSubActivity $activity)
    {
        $validated = $request->validate([
            'tinkering_module_id' => 'required|exists:tinkering_modules,id',
            'title' => 'required|string|max:255',
            'objective' => 'required|string',
            'concept_focus' => 'required|string',
            'materials_needed' => 'required|array|min:1',
            'materials_needed.*' => 'required|string|max:255',
            'instructions' => 'required|string',
            'circuit_diagram' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'explanation' => 'required|string',
            'video_link' => 'nullable|url',
            'is_active' => 'boolean',
            'checklist_items' => 'nullable|array',
            'checklist_items.*.item' => 'required_with:checklist_items|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        // Handle circuit diagram upload
        if ($request->hasFile('circuit_diagram')) {
            // Delete old diagram if exists
            if ($activity->circuit_diagram) {
                Storage::disk('public')->delete($activity->circuit_diagram);
            }
            $validated['circuit_diagram'] = $request->file('circuit_diagram')->store('circuit-diagrams', 'public');
        }

        $activity->update($validated);

        // Update checklist items
        if ($request->has('checklist_items')) {
            // Delete existing checklist items
            $activity->checklists()->delete();
            
            // Create new checklist items
            foreach ($request->checklist_items as $checklistData) {
                if (!empty($checklistData['item'])) {
                    ActivityChecklist::create([
                        'tinkering_module_sub_activity_id' => $activity->id,
                        'item' => $checklistData['item'],
                    ]);
                }
            }
        } else {
            // If no checklist items provided, delete all existing ones
            $activity->checklists()->delete();
        }

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TinkeringModuleSubActivity $activity)
    {
        // Delete circuit diagram if exists
        if ($activity->circuit_diagram) {
            Storage::disk('public')->delete($activity->circuit_diagram);
        }

        $activity->delete();

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activity deleted successfully.');
    }

    /**
     * Activate the activity.
     */
    public function activate(TinkeringModuleSubActivity $activity)
    {
        $activity->activate();

        return redirect()->back()
            ->with('success', 'Activity activated successfully.');
    }

    /**
     * Deactivate the activity.
     */
    public function deactivate(TinkeringModuleSubActivity $activity)
    {
        $activity->deactivate();

        return redirect()->back()
            ->with('success', 'Activity deactivated successfully.');
    }
}
