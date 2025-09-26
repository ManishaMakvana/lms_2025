<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Redeem Code for {{ $module->module_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold mb-4">Unlock Module</h1>
                        <h2 class="text-xl text-gray-600 mb-6">{{ $module->module_name }}</h2>
                        
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
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
                    </div>

                    <form method="POST" action="{{ route('modules.redeem-code', $module) }}" class="max-w-md mx-auto">
                        @csrf
                        
                        @if(session('success'))
                            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="mb-6">
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                Enter Activation Code
                            </label>
                            <input type="text" 
                                   id="code" 
                                   name="code" 
                                   placeholder="e.g., TE-000001"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('code') border-red-500 @enderror"
                                   value="{{ old('code') }}"
                                   required>
                            @error('code')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Unlock Module
                            </button>
                            
                            <a href="{{ route('modules.show', $module) }}" 
                               class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Cancel
                            </a>
                        </div>
                    </form>
                    
                    <div class="mt-8 text-center">
                        <p class="text-sm text-gray-600 mb-2">Available Test Codes:</p>
                        <div class="flex flex-wrap justify-center gap-2">
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">TE-000001</span>
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">TE-000002</span>
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">TE-000003</span>
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">TP-000001</span>
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">TP-000002</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
