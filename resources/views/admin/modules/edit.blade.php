<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Module') }}
            </h2>
            <a href="{{ route('admin.modules.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Modules
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.modules.update', $module) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Module Name -->
                            <div class="md:col-span-2">
                                <label for="module_name" class="block text-sm font-medium text-gray-700">Module Name</label>
                                <input type="text" 
                                       name="module_name" 
                                       id="module_name" 
                                       value="{{ old('module_name', $module->module_name) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('module_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Focus Area -->
                            <div>
                                <label for="focus_area" class="block text-sm font-medium text-gray-700">Focus Area</label>
                                <input type="text" 
                                       name="focus_area" 
                                       id="focus_area" 
                                       value="{{ old('focus_area', $module->focus_area) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('focus_area')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Age Group -->
                            <div>
                                <label for="suggested_age_group" class="block text-sm font-medium text-gray-700">Age Group</label>
                                <input type="text" 
                                       name="suggested_age_group" 
                                       id="suggested_age_group" 
                                       value="{{ old('suggested_age_group', $module->suggested_age_group) }}"
                                       placeholder="e.g., 8-14 years"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('suggested_age_group')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700">Duration</label>
                                <input type="text" 
                                       name="duration" 
                                       id="duration" 
                                       value="{{ old('duration', $module->duration) }}"
                                       placeholder="e.g., 4-6 weeks"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('duration')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" 
                                          id="description" 
                                          rows="4"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                          required>{{ old('description', $module->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Key Skills -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Key Skills</label>
                                <div id="key-skills-container" class="mt-1 space-y-2">
                                    @foreach(old('key_skills', $module->key_skills ?? []) as $index => $skill)
                                        <div class="flex items-center space-x-2">
                                            <input type="text" 
                                                   name="key_skills[]" 
                                                   value="{{ $skill }}"
                                                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                   placeholder="Enter a key skill">
                                            <button type="button" 
                                                    onclick="removeSkill(this)"
                                                    class="text-red-600 hover:text-red-800">Remove</button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" 
                                        onclick="addSkill()"
                                        class="mt-2 text-sm text-blue-600 hover:text-blue-800">+ Add Skill</button>
                                @error('key_skills')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Active Status -->
                            <div class="md:col-span-2">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           id="is_active" 
                                           value="1"
                                           {{ old('is_active', $module->is_active) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                        Active (visible to users)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Module
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addSkill() {
            const container = document.getElementById('key-skills-container');
            const skillDiv = document.createElement('div');
            skillDiv.className = 'flex items-center space-x-2';
            skillDiv.innerHTML = `
                <input type="text" 
                       name="key_skills[]" 
                       class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Enter a key skill">
                <button type="button" 
                        onclick="removeSkill(this)"
                        class="text-red-600 hover:text-red-800">Remove</button>
            `;
            container.appendChild(skillDiv);
        }

        function removeSkill(button) {
            button.parentElement.remove();
        }

        // Add initial skill if none exist
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('key-skills-container');
            if (container.children.length === 0) {
                addSkill();
            }
        });
    </script>
</x-admin-layout>
