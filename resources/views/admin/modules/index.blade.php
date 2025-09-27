<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modules Management') }}
            </h2>
            <a href="{{ route('admin.modules.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors">
                <span class="mr-2">➕</span>Create New Module
            </a>
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-100 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="text-2xl mr-3">📚</div>
                        <div>
                            <p class="text-sm font-medium text-blue-800">Total Modules</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $modules->total() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-green-100 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="text-2xl mr-3">✅</div>
                        <div>
                            <p class="text-sm font-medium text-green-800">Active Modules</p>
                            <p class="text-2xl font-bold text-green-900">{{ $modules->where('is_active', true)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-yellow-100 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="text-2xl mr-3">⏸️</div>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">Inactive Modules</p>
                            <p class="text-2xl font-bold text-yellow-900">{{ $modules->where('is_active', false)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-100 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="text-2xl mr-3">🎯</div>
                        <div>
                            <p class="text-sm font-medium text-purple-800">Total Activities</p>
                            <p class="text-2xl font-bold text-purple-900">{{ $modules->sum(function($module) { return $module->subActivities->count(); }) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search and Filter Section -->
                    <div class="mb-6 flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" 
                                   placeholder="Search modules..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                   id="moduleSearch">
                        </div>
                        <div class="flex gap-2">
                            <select class="px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <button onclick="resetFilters()" class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-md transition-colors">
                                Reset
                            </button>
                        </div>
                    </div>

                    <!-- Modules Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="modulesGrid">
                        @forelse($modules as $module)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 module-card" 
                                 data-status="{{ $module->is_active ? 'active' : 'inactive' }}"
                                 data-name="{{ strtolower($module->module_name) }}"
                                 data-description="{{ strtolower($module->description) }}"
                                 data-focus="{{ strtolower($module->focus_area) }}">
                                
                                <!-- Card Header -->
                                <div class="p-6 border-b border-gray-100">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-1">
                                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $module->module_name }}</h3>
                                                <p class="text-sm text-gray-600 leading-relaxed">{{ Str::limit($module->description, 80) }}</p>
                                                <p class="text-xs text-gray-500 mt-2 flex items-center">
                                                    <span class="mr-1">⏱️</span>
                                                    {{ $module->duration }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <!-- Status Badge -->
                                        <div class="ml-4">
                                            @if($module->is_active)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <span class="w-2 h-2 bg-red-400 rounded-full mr-1"></span>
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="p-6">
                                    <!-- Focus Area -->
                                    <div class="mb-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <span class="mr-1">🎯</span>
                                            {{ $module->focus_area }}
                                        </span>
                                    </div>

                                    <!-- Module Details -->
                                    <div class="space-y-3">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span class="mr-2">👥</span>
                                            <span class="font-medium">Age Group:</span>
                                            <span class="ml-1">{{ $module->suggested_age_group }}</span>
                                        </div>
                                        
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span class="mr-2">🎯</span>
                                            <span class="font-medium">Activities:</span>
                                            <span class="ml-1">{{ $module->subActivities->count() }} activities</span>
                                        </div>
                                        
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span class="mr-2">👤</span>
                                            <span class="font-medium">Created by:</span>
                                            <span class="ml-1">{{ $module->creator->name }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Footer - Actions -->
                                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.modules.show', $module) }}" 
                                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-md transition-colors">
                                                👁️ View
                                            </a>
                                            <a href="{{ route('admin.modules.edit', $module) }}" 
                                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded-md transition-colors">
                                                ✏️ Edit
                                            </a>
                                        </div>
                                        
                                        <div class="flex space-x-1">
                                            @if($module->is_active)
                                                <form method="POST" action="{{ route('admin.modules.deactivate', $module) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center p-1.5 text-xs font-medium text-yellow-600 hover:text-yellow-900 hover:bg-yellow-50 rounded-md transition-colors" title="Deactivate">
                                                        ⏸️
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.modules.activate', $module) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center p-1.5 text-xs font-medium text-green-600 hover:text-green-900 hover:bg-green-50 rounded-md transition-colors" title="Activate">
                                                        ▶️
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('admin.modules.destroy', $module) }}" 
                                                  class="inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this module? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center p-1.5 text-xs font-medium text-red-600 hover:text-red-900 hover:bg-red-50 rounded-md transition-colors" title="Delete">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <div class="text-center py-12">
                                    <div class="text-gray-500">
                                        <div class="text-6xl mb-4">📚</div>
                                        <p class="text-xl font-medium">No modules found</p>
                                        <p class="text-sm mt-2">Create your first module to get started</p>
                                        <a href="{{ route('admin.modules.create') }}" 
                                           class="inline-flex items-center mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors">
                                            <span class="mr-2">➕</span>Create Module
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $modules->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search functionality for cards
        document.getElementById('moduleSearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const cards = document.querySelectorAll('.module-card');
            
            cards.forEach(card => {
                const moduleName = card.getAttribute('data-name');
                const description = card.getAttribute('data-description');
                const focusArea = card.getAttribute('data-focus');
                
                if (moduleName.includes(searchTerm) || description.includes(searchTerm) || focusArea.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Filter functionality for cards
        document.getElementById('statusFilter').addEventListener('change', function() {
            const filterValue = this.value;
            const cards = document.querySelectorAll('.module-card');
            
            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                
                if (filterValue === '' || status === filterValue) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Reset filters
        function resetFilters() {
            document.getElementById('moduleSearch').value = '';
            document.getElementById('statusFilter').value = '';
            
            const cards = document.querySelectorAll('.module-card');
            cards.forEach(card => {
                card.style.display = '';
            });
        }

        // Add hover effects and better UX
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading states to forms
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        if (submitBtn.innerHTML.includes('⏸️') || submitBtn.innerHTML.includes('▶️')) {
                            submitBtn.innerHTML = '⏳';
                        } else {
                            submitBtn.textContent = 'Processing...';
                        }
                    }
                });
            });
            
            // Add tooltips or help text for better UX
            const searchInput = document.getElementById('moduleSearch');
            searchInput.title = 'Search by module name, description, or focus area';
            
            const statusFilter = document.getElementById('statusFilter');
            statusFilter.title = 'Filter modules by their active status';
            
            // Add smooth animations to cards
            const cards = document.querySelectorAll('.module-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</x-admin-layout>
