<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Checklist Item') }}
            </h2>
            <a href="{{ route('admin.activities.show', $activity) }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Activity
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Activity: {{ $activity->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $activity->module->module_name }}</p>
                    </div>

                    <form method="POST" action="{{ route('admin.activities.checklists.update', [$activity, $checklist]) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Checklist Item -->
                            <div class="md:col-span-2">
                                <label for="item" class="block text-sm font-medium text-gray-700">Checklist Item</label>
                                <input type="text" 
                                       name="item" 
                                       id="item" 
                                       value="{{ old('item', $checklist->item) }}"
                                       placeholder="e.g., Gather all required materials"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('item')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Checklist Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
