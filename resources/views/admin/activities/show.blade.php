<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Activity Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.activities.edit', $activity) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Activity
                </a>
                <a href="{{ route('admin.activities.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Activities
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Activity Information -->
                        <div class="lg:col-span-2">
                            <h1 class="text-3xl font-bold mb-4">{{ $activity->title }}</h1>
                            
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Objective</h3>
                                <p class="text-gray-700">{{ $activity->objective }}</p>
                            </div>

                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Concept Focus</h3>
                                <div class="prose max-w-none">
                                    {!! $activity->concept_focus !!}
                                </div>
                            </div>

                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Materials Needed</h3>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($activity->materials_needed as $material)
                                        <li>{{ $material }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Instructions</h3>
                                <div class="prose max-w-none">
                                    {!! $activity->instructions !!}
                                </div>
                            </div>

                            @if($activity->circuit_diagram)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold mb-2">Circuit Diagram</h3>
                                    <img src="{{ asset('storage/' . $activity->circuit_diagram) }}" 
                                         alt="Circuit Diagram" 
                                         class="max-w-full h-auto rounded-lg shadow-md">
                                </div>
                            @endif

                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Explanation</h3>
                                <div class="prose max-w-none">
                                    {!! $activity->explanation !!}
                                </div>
                            </div>

                            @if($activity->video_link)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold mb-2">Video Link</h3>
                                    <a href="{{ $activity->video_link }}" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-800 underline">
                                        {{ $activity->video_link }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Activity Information</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <h4 class="font-medium text-gray-800">Module</h4>
                                        <p class="text-gray-600">{{ $activity->module->module_name }}</p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-medium text-gray-800">Order</h4>
                                        <p class="text-gray-600">{{ $activity->order }}</p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-medium text-gray-800">Status</h4>
                                        @if($activity->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Inactive
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-medium text-gray-800">Checklist Items</h4>
                                        <p class="text-2xl font-bold text-blue-600">{{ $activity->checklists->count() }}</p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-medium text-gray-800">Created</h4>
                                        <p class="text-gray-600">{{ $activity->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Checklist Section -->
                    <div class="mt-8">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold">Checklist Items</h3>
                            <a href="{{ route('admin.activities.checklists.create', $activity) }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Checklist Item
                            </a>
                        </div>
                        
                        @if($activity->checklists->count() > 0)
                            <div class="space-y-2">
                                @foreach($activity->checklists as $checklist)
                                    <div class="bg-gray-50 p-4 rounded-lg flex items-center justify-between">
                                        <div class="flex items-center">
                                            <span class="text-sm text-gray-500 mr-4">#{{ $checklist->order }}</span>
                                            <span class="text-gray-800">{{ $checklist->item }}</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.activities.checklists.edit', [$activity, $checklist]) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                                            <form method="POST" action="{{ route('admin.activities.checklists.destroy', [$activity, $checklist]) }}" 
                                                  onsubmit="return confirm('Are you sure you want to delete this checklist item?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-lg">
                                <p class="text-gray-500 mb-4">No checklist items found for this activity.</p>
                                <a href="{{ route('admin.activities.checklists.create', $activity) }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Add First Checklist Item
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
