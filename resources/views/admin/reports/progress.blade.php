<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Progress Report') }}
            </h2>
            <a href="{{ route('admin.reports') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Back to Reports
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Progress Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Modules -->
                <div class="bg-blue-100 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="text-3xl mr-4">📚</div>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800">Total Modules</h3>
                            <p class="text-3xl font-bold text-blue-900">{{ \App\Models\TinkeringModule::count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Modules -->
                <div class="bg-green-100 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="text-3xl mr-4">✅</div>
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

                <!-- Module Unlocks -->
                <div class="bg-purple-100 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="text-3xl mr-4">🔓</div>
                        <div>
                            <h3 class="text-lg font-semibold text-purple-800">Module Unlocks</h3>
                            <p class="text-3xl font-bold text-purple-900">{{ \App\Models\ModuleUser::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Module Progress Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Module Progress Overview</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @php
                            $modules = \App\Models\TinkeringModule::with(['users', 'subActivities'])->get();
                        @endphp
                        @foreach($modules as $module)
                            @php
                                $totalUsers = \App\Models\User::where('role', 'student')->count();
                                $unlockedUsers = $module->users->count();
                                $completionRate = $totalUsers > 0 ? round(($unlockedUsers / $totalUsers) * 100, 1) : 0;
                            @endphp
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-gray-900">{{ $module->module_name }}</h4>
                                    <span class="text-sm text-gray-500">{{ $unlockedUsers }} / {{ $totalUsers }} students</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $completionRate }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>{{ $completionRate }}% unlocked</span>
                                    <span>{{ $module->subActivities->count() }} activities</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Student Progress Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Student Progress</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Student
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Modules Unlocked
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Activities Completed
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Progress
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last Activity
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $students = \App\Models\User::where('role', 'student')->with(['unlockedModules', 'activityProgress'])->orderBy('created_at', 'desc')->paginate(15);
                            @endphp
                            @forelse($students as $student)
                                @php
                                    $unlockedModules = $student->unlockedModules->count();
                                    $completedActivities = $student->activityProgress->count();
                                    $totalModules = \App\Models\TinkeringModule::where('is_active', true)->count();
                                    $progressPercentage = $totalModules > 0 ? round(($unlockedModules / $totalModules) * 100, 1) : 0;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-white font-bold text-xs">{{ substr($student->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $student->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $unlockedModules }} modules
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $completedActivities }} activities
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600">{{ $progressPercentage }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $student->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No students found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 bg-gray-50">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
