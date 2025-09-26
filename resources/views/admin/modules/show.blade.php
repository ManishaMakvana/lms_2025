<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Module Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.modules.edit', $module) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Module
                </a>
                <a href="{{ route('admin.modules.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Modules
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Module Information -->
                        <div class="lg:col-span-2">
                            <h1 class="text-3xl font-bold mb-4">{{ $module->module_name }}</h1>
                            
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Description</h3>
                                <p class="text-gray-700">{{ $module->description }}</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <h4 class="font-semibold text-gray-800">Focus Area</h4>
                                    <p class="text-gray-600">{{ $module->focus_area }}</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Age Group</h4>
                                    <p class="text-gray-600">{{ $module->suggested_age_group }}</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Duration</h4>
                                    <p class="text-gray-600">{{ $module->duration }}</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Status</h4>
                                    @if($module->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-6">
                                <h4 class="font-semibold text-gray-800 mb-2">Key Skills</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($module->key_skills as $skill)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Module Statistics</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <h4 class="font-medium text-gray-800">Activities</h4>
                                        <p class="text-2xl font-bold text-blue-600">{{ $module->subActivities->count() }}</p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-medium text-gray-800">Enrolled Users</h4>
                                        <p class="text-2xl font-bold text-green-600">{{ $module->users->count() }}</p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-medium text-gray-800">Created By</h4>
                                        <p class="text-gray-600">{{ $module->creator->name }}</p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-medium text-gray-800">Created</h4>
                                        <p class="text-gray-600">{{ $module->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activities Section -->
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold mb-4">Activities in this Module</h3>
                        @if($module->subActivities->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($module->subActivities as $activity)
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-gray-800">{{ $activity->title }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($activity->objective, 80) }}</p>
                                        <div class="mt-2 flex items-center justify-between">
                                            <span class="text-xs text-gray-500">Order: {{ $activity->order }}</span>
                                            @if($activity->is_active)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No activities found for this module.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
