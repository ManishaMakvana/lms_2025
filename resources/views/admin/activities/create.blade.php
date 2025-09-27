<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Activity') }}
            </h2>
            <a href="{{ route('admin.activities.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Activities
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.activities.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Module Selection -->
                            <div class="md:col-span-2">
                                <label for="tinkering_module_id" class="block text-sm font-medium text-gray-700">Module</label>
                                <select name="tinkering_module_id" 
                                        id="tinkering_module_id" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <option value="">Select a module</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}" {{ old('tinkering_module_id') == $module->id ? 'selected' : '' }}>
                                            {{ $module->module_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tinkering_module_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Activity Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700">Activity Title</label>
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       value="{{ old('title') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Video Link -->
                            <div>
                                <label for="video_link" class="block text-sm font-medium text-gray-700">Video Link (Optional)</label>
                                <input type="url" 
                                       name="video_link" 
                                       id="video_link" 
                                       value="{{ old('video_link') }}"
                                       placeholder="https://youtube.com/watch?v=..."
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('video_link')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Objective -->
                            <div class="md:col-span-2">
                                <label for="objective" class="block text-sm font-medium text-gray-700">Objective</label>
                                <textarea name="objective" 
                                          id="objective" 
                                          rows="3"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                          required>{{ old('objective') }}</textarea>
                                @error('objective')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Concept Focus -->
                            <div class="md:col-span-2">
                                <label for="concept_focus" class="block text-sm font-medium text-gray-700">Concept Focus</label>
                                <textarea name="concept_focus" 
                                          id="concept_focus" 
                                          rows="4"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                          required>{{ old('concept_focus') }}</textarea>
                                @error('concept_focus')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Materials Needed -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Materials Needed</label>
                                <div id="materials-container" class="mt-1 space-y-2">
                                    <div class="flex items-center space-x-2">
                                        <input type="text" 
                                               name="materials_needed[]" 
                                               value="{{ old('materials_needed.0') }}"
                                               class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Enter a material">
                                        <button type="button" 
                                                onclick="removeMaterial(this)"
                                                class="text-red-600 hover:text-red-800">Remove</button>
                                    </div>
                                </div>
                                <button type="button" 
                                        onclick="addMaterial()"
                                        class="mt-2 text-sm text-blue-600 hover:text-blue-800">+ Add Material</button>
                                @error('materials_needed')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Checklist Items -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Checklist Items</label>
                                <p class="mt-1 text-sm text-gray-500 mb-3">Add multiple checklist items to help users track their progress</p>
                                <div id="checklist-container" class="mt-1 space-y-3">
                                    <!-- Checklist items will be added here -->
                                </div>
                                <button type="button" 
                                        onclick="addChecklistItem()"
                                        class="mt-3 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Checklist Item
                                </button>
                                @error('checklist_items')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Instructions -->
                            <div class="md:col-span-2">
                                <label for="instructions" class="block text-sm font-medium text-gray-700">Instructions</label>
                                <textarea name="instructions" 
                                          id="instructions" 
                                          rows="6"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Enter step-by-step instructions in numbered format:
1. First step description
2. Second step description
3. Third step description"
                                          required>{{ old('instructions') }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">Format: Use numbered steps (1., 2., 3., etc.) for clear instructions</p>
                                @error('instructions')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Circuit Diagram -->
                            <div class="md:col-span-2">
                                <label for="circuit_diagram" class="block text-sm font-medium text-gray-700">Circuit Diagram (Optional)</label>
                                <input type="file" 
                                       name="circuit_diagram" 
                                       id="circuit_diagram" 
                                       accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @error('circuit_diagram')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Explanation -->
                            <div class="md:col-span-2">
                                <label for="explanation" class="block text-sm font-medium text-gray-700">Explanation</label>
                                <textarea name="explanation" 
                                          id="explanation" 
                                          rows="6"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                          required>{{ old('explanation') }}</textarea>
                                @error('explanation')
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
                                           {{ old('is_active', true) ? 'checked' : '' }}
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
                                Create Activity
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let checklistCounter = 0;

        function addMaterial() {
            const container = document.getElementById('materials-container');
            const materialDiv = document.createElement('div');
            materialDiv.className = 'flex items-center space-x-2';
            materialDiv.innerHTML = `
                <input type="text" 
                       name="materials_needed[]" 
                       class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Enter a material">
                <button type="button" 
                        onclick="removeMaterial(this)"
                        class="text-red-600 hover:text-red-800">Remove</button>
            `;
            container.appendChild(materialDiv);
        }

        function removeMaterial(button) {
            button.parentElement.remove();
        }

        function addChecklistItem() {
            const container = document.getElementById('checklist-container');
            const checklistDiv = document.createElement('div');
            checklistDiv.className = 'bg-gray-50 p-4 rounded-lg border';
            checklistDiv.innerHTML = `
                <div class="flex items-start space-x-3">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <label class="text-sm font-medium text-gray-700">Item:</label>
                            <input type="text" 
                                   name="checklist_items[${checklistCounter}][item]" 
                                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter checklist item"
                                   required>
                        </div>
                    </div>
                    <button type="button" 
                            onclick="removeChecklistItem(this)"
                            class="text-red-600 hover:text-red-800 text-sm font-medium">Remove</button>
                </div>
            `;
            container.appendChild(checklistDiv);
            checklistCounter++;
        }

        function removeChecklistItem(button) {
            button.closest('.bg-gray-50').remove();
        }

        // Add initial material if none exist
        document.addEventListener('DOMContentLoaded', function() {
            const materialsContainer = document.getElementById('materials-container');
            if (materialsContainer.children.length === 0) {
                addMaterial();
            }
            
            // Add one initial checklist item
            addChecklistItem();
        });
    </script>
</x-admin-layout>
