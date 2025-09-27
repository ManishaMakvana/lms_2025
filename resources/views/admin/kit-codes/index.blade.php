<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kit Codes Management') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.kit-codes.export') }}" 
                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    📊 Export CSV
                </a>
                <a href="{{ route('admin.kit-codes.create') }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    ➕ Generate Codes
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Codes -->
                <div class="bg-blue-100 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="text-3xl mr-4">🔑</div>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800">Total Codes</h3>
                            <p class="text-3xl font-bold text-blue-900">{{ $totalCodes }}</p>
                        </div>
                    </div>
                </div>

                <!-- Available Codes -->
                <div class="bg-green-100 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="text-3xl mr-4">✅</div>
                        <div>
                            <h3 class="text-lg font-semibold text-green-800">Available</h3>
                            <p class="text-3xl font-bold text-green-900">{{ $availableCodes }}</p>
                        </div>
                    </div>
                </div>

                <!-- Used Codes -->
                <div class="bg-orange-100 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="text-3xl mr-4">👤</div>
                        <div>
                            <h3 class="text-lg font-semibold text-orange-800">Used</h3>
                            <p class="text-3xl font-bold text-orange-900">{{ $usedCodes }}</p>
                        </div>
                    </div>
                </div>

                <!-- Blocked Codes -->
                <div class="bg-red-100 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="text-3xl mr-4">🚫</div>
                        <div>
                            <h3 class="text-lg font-semibold text-red-800">Blocked</h3>
                            <p class="text-3xl font-bold text-red-900">{{ $blockedCodes }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kit Codes Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Bulk Actions -->
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Select All</span>
                            </label>
                            <button type="button" 
                                    id="bulk-delete-btn" 
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                🗑️ Delete Selected
                            </button>
                            <span id="selected-count" class="text-sm text-gray-500">0 selected</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            Showing {{ $kitCodes->firstItem() ?? 0 }} to {{ $kitCodes->lastItem() ?? 0 }} of {{ $kitCodes->total() }} results
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <input type="checkbox" id="select-all-header" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Code
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Module
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Generated By
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Generated At
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Used By
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($kitCodes as $kitCode)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" 
                                                   class="kit-code-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                                   value="{{ $kitCode->id }}">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-white font-bold text-xs">K</span>
                                                </div>
                                                <span class="text-sm font-medium text-gray-900 font-mono">{{ $kitCode->code }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $kitCode->module->module_name ?? 'No Module' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($kitCode->status === 'unused')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Available
                                                </span>
                                            @elseif($kitCode->status === 'used')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                    Used
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Blocked
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $kitCode->generatedBy->name ?? 'Unknown' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $kitCode->created_at->format('M d, Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $kitCode->usedBy->name ?? 'Not Used' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.kit-codes.show', $kitCode) }}" 
                                                   class="text-blue-600 hover:text-blue-900">View</a>
                                                <a href="{{ route('admin.kit-codes.edit', $kitCode) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form method="POST" action="{{ route('admin.kit-codes.destroy', $kitCode) }}" 
                                                      class="inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this kit code?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No kit codes found. <a href="{{ route('admin.kit-codes.create') }}" class="text-blue-600 hover:text-blue-800">Generate some codes</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $kitCodes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Delete Form -->
    <form id="bulk-delete-form" method="POST" action="{{ route('admin.kit-codes.bulk-delete') }}" style="display: none;">
        @csrf
        <input type="hidden" name="kit_code_ids" id="bulk-delete-ids">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const selectAllHeaderCheckbox = document.getElementById('select-all-header');
            const kitCodeCheckboxes = document.querySelectorAll('.kit-code-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const selectedCountSpan = document.getElementById('selected-count');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');
            const bulkDeleteIdsInput = document.getElementById('bulk-delete-ids');

            // Select all functionality
            function updateSelectAll() {
                const checkedBoxes = document.querySelectorAll('.kit-code-checkbox:checked');
                const totalBoxes = kitCodeCheckboxes.length;
                
                if (checkedBoxes.length === 0) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = false;
                    selectAllHeaderCheckbox.indeterminate = false;
                    selectAllHeaderCheckbox.checked = false;
                } else if (checkedBoxes.length === totalBoxes) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = true;
                    selectAllHeaderCheckbox.indeterminate = false;
                    selectAllHeaderCheckbox.checked = true;
                } else {
                    selectAllCheckbox.indeterminate = true;
                    selectAllCheckbox.checked = false;
                    selectAllHeaderCheckbox.indeterminate = true;
                    selectAllHeaderCheckbox.checked = false;
                }
            }

            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.kit-code-checkbox:checked');
                const count = checkedBoxes.length;
                
                selectedCountSpan.textContent = count + ' selected';
                bulkDeleteBtn.disabled = count === 0;
            }

            // Event listeners
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                kitCodeCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                selectAllHeaderCheckbox.checked = isChecked;
                selectAllHeaderCheckbox.indeterminate = false;
                updateSelectedCount();
            });

            selectAllHeaderCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                kitCodeCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                selectAllCheckbox.checked = isChecked;
                selectAllCheckbox.indeterminate = false;
                updateSelectedCount();
            });

            kitCodeCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectAll();
                    updateSelectedCount();
                });
            });

            // Bulk delete functionality
            bulkDeleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const checkedBoxes = document.querySelectorAll('.kit-code-checkbox:checked');
                const ids = Array.from(checkedBoxes).map(checkbox => checkbox.value);
                
                if (ids.length === 0) {
                    alert('Please select at least one kit code to delete.');
                    return;
                }

                const count = ids.length;
                const confirmMessage = `Are you sure you want to delete ${count} kit code${count > 1 ? 's' : ''}? This action cannot be undone.`;
                
                if (confirm(confirmMessage)) {
                    bulkDeleteIdsInput.value = JSON.stringify(ids);
                    console.log('Submitting bulk delete form with IDs:', ids);
                    console.log('Form action:', bulkDeleteForm.action);
                    console.log('Form method:', bulkDeleteForm.method);
                    bulkDeleteForm.submit();
                }
            });

            // Initialize
            updateSelectAll();
            updateSelectedCount();
        });
    </script>
</x-admin-layout>
