<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports & Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Reports Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Usage Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <span class="text-2xl mr-3">📊</span>
                            Usage Reports
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Track how users interact with the system</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <a href="{{ route('admin.reports.usage') }}" 
                               class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-white text-xl">👥</span>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">User Activity Report</h4>
                                    <p class="text-sm text-gray-600">View user login activity, module access, and engagement metrics</p>
                                </div>
                                <div class="ml-auto">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>
                            
                            <a href="{{ route('admin.reports.progress') }}" 
                               class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-white text-xl">📈</span>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Progress Report</h4>
                                    <p class="text-sm text-gray-600">Track student progress through modules and activities</p>
                                </div>
                                <div class="ml-auto">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Analytics -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <span class="text-2xl mr-3">🔍</span>
                            System Analytics
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Monitor system performance and usage patterns</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-white text-xl">📚</span>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Module Analytics</h4>
                                    <p class="text-sm text-gray-600">Most popular modules, completion rates, and user feedback</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-4 bg-orange-50 rounded-lg">
                                <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-white text-xl">🔑</span>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Kit Code Analytics</h4>
                                    <p class="text-sm text-gray-600">Code generation, usage patterns, and redemption statistics</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Users -->
                <div class="bg-blue-100 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="text-3xl mr-4">👥</div>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800">Total Users</h3>
                            <p class="text-3xl font-bold text-blue-900">{{ \App\Models\User::count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Modules -->
                <div class="bg-green-100 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="text-3xl mr-4">📚</div>
                        <div>
                            <h3 class="text-lg font-semibold text-green-800">Active Modules</h3>
                            <p class="text-3xl font-bold text-green-900">{{ \App\Models\TinkeringModule::where('is_active', true)->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Activities -->
                <div class="bg-yellow-100 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="text-3xl mr-4">🎯</div>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-800">Total Activities</h3>
                            <p class="text-3xl font-bold text-yellow-900">{{ \App\Models\TinkeringModuleSubActivity::count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Kit Codes Generated -->
                <div class="bg-purple-100 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="text-3xl mr-4">🔑</div>
                        <div>
                            <h3 class="text-lg font-semibold text-purple-800">Kit Codes</h3>
                            <p class="text-3xl font-bold text-purple-900">{{ \App\Models\KitActivationCode::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <span class="text-2xl mr-3">⚡</span>
                        Recent System Activity
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @php
                            $recentUsers = \App\Models\User::orderBy('created_at', 'desc')->limit(5)->get();
                            $recentModules = \App\Models\TinkeringModule::orderBy('created_at', 'desc')->limit(5)->get();
                            $recentCodes = \App\Models\KitActivationCode::orderBy('created_at', 'desc')->limit(5)->get();
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Recent Users -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-3">Recent Users</h4>
                                <div class="space-y-2">
                                    @foreach($recentUsers as $user)
                                        <div class="flex items-center text-sm">
                                            <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mr-2">
                                                <span class="text-white text-xs font-bold">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                            <span class="text-gray-700">{{ $user->name }}</span>
                                            <span class="text-gray-500 ml-auto">{{ $user->created_at->diffForHumans() }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Recent Modules -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-3">Recent Modules</h4>
                                <div class="space-y-2">
                                    @foreach($recentModules as $module)
                                        <div class="flex items-center text-sm">
                                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-2">
                                                <span class="text-white text-xs">📚</span>
                                            </div>
                                            <span class="text-gray-700">{{ Str::limit($module->module_name, 20) }}</span>
                                            <span class="text-gray-500 ml-auto">{{ $module->created_at->diffForHumans() }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Recent Kit Codes -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-3">Recent Kit Codes</h4>
                                <div class="space-y-2">
                                    @foreach($recentCodes as $code)
                                        <div class="flex items-center text-sm">
                                            <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center mr-2">
                                                <span class="text-white text-xs font-bold">K</span>
                                            </div>
                                            <span class="text-gray-700 font-mono">{{ $code->code }}</span>
                                            <span class="text-gray-500 ml-auto">{{ $code->created_at->diffForHumans() }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Options -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <span class="text-2xl mr-3">📤</span>
                        Export Data
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('admin.kit-codes.export') }}" 
                           class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-sm">🔑</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Kit Codes</h4>
                                <p class="text-xs text-gray-600">CSV Export</p>
                            </div>
                        </a>

                        <div class="flex items-center p-4 bg-green-50 rounded-lg">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-sm">👥</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Users</h4>
                                <p class="text-xs text-gray-600">Coming Soon</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-yellow-50 rounded-lg">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-sm">📚</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Modules</h4>
                                <p class="text-xs text-gray-600">Coming Soon</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-sm">📊</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Analytics</h4>
                                <p class="text-xs text-gray-600">Coming Soon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
