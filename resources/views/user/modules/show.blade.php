<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $module->module_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Module Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">{{ $module->module_name }}</h1>
                            <p class="text-gray-600 text-lg">{{ $module->description }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">
                                ✓ Unlocked
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-blue-800">Focus Area</h3>
                            <p class="text-blue-600">{{ $module->focus_area }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-green-800">Age Group</h3>
                            <p class="text-green-600">{{ $module->suggested_age_group }}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-purple-800">Duration</h3>
                            <p class="text-purple-600">{{ $module->duration }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">Key Skills You'll Learn:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($module->key_skills as $skill)
                                <span class="inline-block bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-Activities List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Sub-Activities</h2>
                    
                    @if($module->subActivities->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($module->subActivities as $index => $activity)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow cursor-pointer"
                                     onclick="window.location.href='{{ route('modules.activities.show', [$module, $activity]) }}'">
                                    <!-- Activity Header -->
                                    <div class="text-center mb-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <span class="text-white font-bold text-lg">{{ $index + 1 }}</span>
                                        </div>
                                        <h3 class="text-lg font-semibold mb-2">{{ $activity->title }}</h3>
                                        <p class="text-gray-600 text-sm">{{ Str::limit($activity->objective, 100) }}</p>
                                    </div>
                                    
                                    <!-- Activity Info -->
                                    <div class="mb-4 space-y-2">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-500">Concept:</span>
                                            <span class="font-medium text-xs">{{ Str::limit($activity->concept_focus, 30) }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-500">Materials:</span>
                                            <span class="font-medium">{{ count($activity->materials_needed) }} items</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-500">Checklist:</span>
                                            <span class="font-medium">{{ $activity->checklists->count() }} items</span>
                                        </div>
                                    </div>

                                    <!-- Activity Features -->
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @if($activity->circuit_diagram)
                                            <span class="inline-block bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full">
                                                🔌 Diagram
                                            </span>
                                        @endif
                                        @if($activity->video_link)
                                            <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                                🎥 Video
                                            </span>
                                        @endif
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                            📋 Checklist
                                        </span>
                                    </div>
                                    
                                    <!-- Start Button -->
                                    <div class="text-center">
                                        <a href="{{ route('modules.activities.show', [$module, $activity]) }}" 
                                           class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors w-full text-center">
                                            Start Activity
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 text-lg">No sub-activities available for this module yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
