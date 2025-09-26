<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TinkeringModule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = TinkeringModule::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.modules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_name' => 'required|string|max:255',
            'description' => 'required|string',
            'focus_area' => 'required|string|max:255',
            'suggested_age_group' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'key_skills' => 'required|array|min:1',
            'key_skills.*' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['module_name']);
        $validated['created_by'] = auth()->id();
        $validated['is_active'] = $request->has('is_active');

        TinkeringModule::create($validated);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TinkeringModule $module)
    {
        $module->load(['creator', 'subActivities', 'users']);
        
        return view('admin.modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TinkeringModule $module)
    {
        return view('admin.modules.edit', compact('module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TinkeringModule $module)
    {
        $validated = $request->validate([
            'module_name' => 'required|string|max:255',
            'description' => 'required|string',
            'focus_area' => 'required|string|max:255',
            'suggested_age_group' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'key_skills' => 'required|array|min:1',
            'key_skills.*' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['module_name']);
        $validated['is_active'] = $request->has('is_active');

        $module->update($validated);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TinkeringModule $module)
    {
        $module->delete();

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module deleted successfully.');
    }

    /**
     * Activate the module.
     */
    public function activate(TinkeringModule $module)
    {
        $module->activate();

        return redirect()->back()
            ->with('success', 'Module activated successfully.');
    }

    /**
     * Deactivate the module.
     */
    public function deactivate(TinkeringModule $module)
    {
        $module->deactivate();

        return redirect()->back()
            ->with('success', 'Module deactivated successfully.');
    }
}
