<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityChecklist;
use App\Models\TinkeringModuleSubActivity;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checklists = ActivityChecklist::with(['subActivity.module'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.checklists.index', compact('checklists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(TinkeringModuleSubActivity $activity)
    {
        return view('admin.activities.checklists.create', compact('activity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TinkeringModuleSubActivity $activity)
    {
        $validated = $request->validate([
            'item' => 'required|string|max:255',
        ]);

        $validated['tinkering_module_sub_activity_id'] = $activity->id;
        ActivityChecklist::create($validated);

        return redirect()->route('admin.activities.show', $activity)
            ->with('success', 'Checklist item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityChecklist $checklist)
    {
        $checklist->load(['subActivity.module']);
        
        return view('admin.checklists.show', compact('checklist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TinkeringModuleSubActivity $activity, ActivityChecklist $checklist)
    {
        return view('admin.activities.checklists.edit', compact('activity', 'checklist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TinkeringModuleSubActivity $activity, ActivityChecklist $checklist)
    {
        $validated = $request->validate([
            'item' => 'required|string|max:255',
        ]);

        $checklist->update($validated);

        return redirect()->route('admin.activities.show', $activity)
            ->with('success', 'Checklist item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TinkeringModuleSubActivity $activity, ActivityChecklist $checklist)
    {
        $checklist->delete();

        return redirect()->route('admin.activities.show', $activity)
            ->with('success', 'Checklist item deleted successfully.');
    }
}
