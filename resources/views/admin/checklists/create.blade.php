<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Checklist Item') }}
            </h2>
            <a href="{{ route('admin.checklists.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Checklists
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.checklists.store') }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Activity Selection -->
                            <div class="md:col-span-2">
                                <label for="tinkering_module_sub_activity_id" class="block text-sm font-medium text-gray-700">Activity</label>
                                <select name="tinkering_module_sub_activity_id" 
                                        id="tinkering_module_sub_activity_id" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <option value="">Select an activity</option>
                                    @foreach($activities as $activity)
                                        <option value="{{ $activity->id }}" {{ old('tinkering_module_sub_activity_id') == $activity->id ? 'selected' : '' }}>
                                            {{ $activity->module->module_name }} - {{ $activity->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tinkering_module_sub_activity_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Checklist Item -->
                            <div class="md:col-span-2">
                                <label for="item" class="block text-sm font-medium text-gray-700">Checklist Item</label>
                                <input type="text" 
                                       name="item" 
                                       id="item" 
                                       value="{{ old('item') }}"
                                       placeholder="e.g., Gather all required materials"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('item')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Order -->
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
                                <input type="number" 
                                       name="order" 
                                       id="order" 
                                       value="{{ old('order', 1) }}"
                                       min="1"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('order')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">The order in which this item appears in the checklist</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Checklist Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
