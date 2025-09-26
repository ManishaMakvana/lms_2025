<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Modules') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Tinkering Modules</h1>
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($modules as $module)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                                <!-- Module Header -->
                                <div class="text-center mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <span class="text-white font-bold text-xl">
                                            {{ strtoupper(substr($module->module_name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <h3 class="text-lg font-semibold mb-2">{{ $module->module_name }}</h3>
                                    <p class="text-gray-600 text-sm">{{ Str::limit($module->description, 80) }}</p>
                                </div>
                                
                                <!-- Module Info -->
                                <div class="mb-4 space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Focus:</span>
                                        <span class="font-medium">{{ $module->focus_area }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Age Group:</span>
                                        <span class="font-medium">{{ $module->suggested_age_group }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Duration:</span>
                                        <span class="font-medium">{{ $module->duration }}</span>
                                    </div>
                                </div>

                                @php
                                    $hasAccess = in_array($module->id, $unlockedModuleIds);
                                @endphp

                                @if($hasAccess || auth()->user()->isAdmin())
                                    <div class="mb-4 text-center">
                                        <span class="inline-block bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">
                                            @if(auth()->user()->isAdmin())
                                                👑 Admin Access
                                            @else
                                                ✓ Unlocked
                                            @endif
                                        </span>
                                    </div>
                                    <a href="{{ route('modules.show', $module) }}" 
                                       class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors block text-center">
                                        @if(auth()->user()->isAdmin())
                                            View Module
                                        @else
                                            Start Learning
                                        @endif
                                    </a>
                                @else
                                    <div class="mb-4 text-center">
                                        <span class="inline-block bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">
                                            🔒 Locked
                                        </span>
                                    </div>
                                    <button onclick="openRedeemModal('{{ $module->slug }}', '{{ $module->module_name }}')"
                                            class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors block text-center">
                                        Unlock Module
                                    </button>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-500 text-lg">No modules available at the moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Redeem Code Modal -->
    <div id="redeemModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="redeemForm" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                    Unlock Module: <span id="moduleName"></span>
                                </h3>
                                <div class="mb-4">
                                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                        Enter 6-Digit Activation Code
                                    </label>
                                    <div class="flex items-center">
                                        <span id="codePrefix" class="px-3 py-2 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md text-gray-700 font-mono">TE-</span>
                                        <input type="text" 
                                               id="code" 
                                               name="code" 
                                               placeholder="000001"
                                               maxlength="6"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono"
                                               required>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Enter only the 6 digits after the prefix</p>
                                    @error('code')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Unlock Module
                        </button>
                        <button type="button" 
                                onclick="closeRedeemModal()"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRedeemModal(moduleSlug, moduleName) {
            document.getElementById('moduleName').textContent = moduleName;
            document.getElementById('redeemForm').action = `/modules/${moduleSlug}/redeem-code`;
            document.getElementById('redeemModal').classList.remove('hidden');
        }

        function closeRedeemModal() {
            document.getElementById('redeemModal').classList.add('hidden');
            document.getElementById('code').value = '';
        }

        // Close modal when clicking outside
        document.getElementById('redeemModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRedeemModal();
            }
        });
    </script>
</x-app-layout>
