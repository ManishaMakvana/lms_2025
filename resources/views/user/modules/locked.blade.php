<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Module Locked') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center">
                        <div class="mb-6">
                            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-gray-100">
                                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                        
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $module->module_name }}</h1>
                        <p class="text-lg text-gray-600 mb-8">This module is locked. Enter your activation code to unlock it.</p>
                        
                        <div class="bg-gray-50 rounded-lg p-6 mb-8">
                            <h3 class="text-lg font-semibold mb-4">Module Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                                <div>
                                    <p class="text-sm text-gray-600">Focus Area:</p>
                                    <p class="font-medium">{{ $module->focus_area }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Age Group:</p>
                                    <p class="font-medium">{{ $module->suggested_age_group }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Duration:</p>
                                    <p class="font-medium">{{ $module->duration }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Activities:</p>
                                    <p class="font-medium">{{ $module->subActivities->count() }} activities</p>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 mb-2">Key Skills:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($module->key_skills as $skill)
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('modules.redeem-code', $module) }}" class="max-w-md mx-auto">
                            @csrf
                            <div class="mb-4">
                                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                    Activation Code
                                </label>
                                <input type="text" 
                                       id="code" 
                                       name="code" 
                                       placeholder="e.g., TE-000001"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       required>
                                @error('code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Unlock Module
                            </button>
                        </form>
                        
                        <div class="mt-6">
                            <a href="{{ route('modules.index') }}" 
                               class="text-blue-600 hover:text-blue-800">
                                ← Back to Modules
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
