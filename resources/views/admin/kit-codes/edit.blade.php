<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kit Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.kit-codes.update', $kitCode) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kit Code Display -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kit Code</label>
                                <div class="flex items-center p-3 bg-gray-100 rounded-lg">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white font-bold">K</span>
                                    </div>
                                    <span class="text-xl font-bold text-gray-900 font-mono">{{ $kitCode->code }}</span>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Kit codes cannot be changed once generated.</p>
                            </div>

                            <!-- Module Selection -->
                            <div class="md:col-span-2">
                                <label for="module_id" class="block text-sm font-medium text-gray-700">Module</label>
                                <select name="module_id" 
                                        id="module_id" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}" {{ old('module_id', $kitCode->module_id) == $module->id ? 'selected' : '' }}>
                                            {{ $module->module_name }} - {{ $module->focus_area }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('module_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status Selection -->
                            <div class="md:col-span-2">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" 
                                        id="status" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <option value="unused" {{ old('status', $kitCode->status) === 'unused' ? 'selected' : '' }}>
                                        Available - Code can be used by students
                                    </option>
                                    <option value="used" {{ old('status', $kitCode->status) === 'used' ? 'selected' : '' }}>
                                        Used - Code has been redeemed by a student
                                    </option>
                                    <option value="blocked" {{ old('status', $kitCode->status) === 'blocked' ? 'selected' : '' }}>
                                        Blocked - Code is disabled and cannot be used
                                    </option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Information Card -->
                        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">
                                        Status Information
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li><strong>Available:</strong> Code can be used by students to unlock the module</li>
                                            <li><strong>Used:</strong> Code has been redeemed and cannot be used again</li>
                                            <li><strong>Blocked:</strong> Code is disabled and cannot be used (useful for invalid codes)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Usage History -->
                        @if($kitCode->usedBy)
                            <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                                <h3 class="text-sm font-medium text-green-800 mb-2">Usage History</h3>
                                <div class="text-sm text-green-700">
                                    <p><strong>Used by:</strong> {{ $kitCode->usedBy->name }}</p>
                                    <p><strong>Used at:</strong> {{ $kitCode->used_at ? $kitCode->used_at->format('F d, Y \a\t H:i') : 'Unknown' }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Submit Buttons -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.kit-codes.show', $kitCode) }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                💾 Update Kit Code
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
