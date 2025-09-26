<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checklist Item Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.checklists.edit', $checklist) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Checklist Item
                </a>
                <a href="{{ route('admin.checklists.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Checklists
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Checklist Information -->
                        <div class="lg:col-span-2">
                            <h1 class="text-3xl font-bold mb-4">{{ $checklist->item }}</h1>
                            
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Activity Information</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-gray-800">{{ $checklist->subActivity->title }}</h4>
                                    <p class="text-gray-600">{{ $checklist->subActivity->module->module_name }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit($checklist->subActivity->objective, 100) }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <h4 class="font-semibold text-gray-800">Order</h4>
                                    <p class="text-gray-600">{{ $checklist->order }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="font-semibold text-gray-800">Created</h4>
                                    <p class="text-gray-600">{{ $checklist->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                                
                                <div class="space-y-3">
                                    <a href="{{ route('admin.checklists.edit', $checklist) }}" 
                                       class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center block">
                                        Edit Checklist Item
                                    </a>
                                    
                                    <form method="POST" action="{{ route('admin.checklists.destroy', $checklist) }}" 
                                          onsubmit="return confirm('Are you sure you want to delete this checklist item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center">
                                            Delete Checklist Item
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
