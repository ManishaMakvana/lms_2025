<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
                <p class="text-sm text-gray-600 mt-1">Welcome back, {{ auth()->user()->name }}! Here's what's happening with your LMS.</p>
            </div>
            <div class="flex space-x-3">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                    📊 Quick Reports
                </button>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                    ⚡ Quick Actions
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-6 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">🎓 Learning Management System</h1>
                        <p class="text-blue-100">Manage your educational content, track progress, and engage with learners</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="text-right">
                            <div class="text-3xl font-bold">{{ $totalUsers }}</div>
                            <div class="text-blue-200">Active Learners</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Enhanced Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Total Users -->
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-xl shadow-lg text-white hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-blue-100 mb-1">Total Learners</h3>
                                    <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                                    <p class="text-xs text-blue-200 mt-1">+12% from last month</p>
                                </div>
                                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                    <span class="text-2xl">👥</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-xs text-blue-200">
                                    <span class="mr-1">📈</span>
                                    <span>Growing steadily</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Total Modules -->
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 rounded-xl shadow-lg text-white hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-green-100 mb-1">Active Courses</h3>
                                    <p class="text-3xl font-bold">{{ $totalModules }}</p>
                                    <p class="text-xs text-green-200 mt-1">{{ $totalActivities }} activities</p>
                                </div>
                                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                    <span class="text-2xl">📚</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-xs text-green-200">
                                    <span class="mr-1">🎯</span>
                                    <span>Content rich</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Engagement Rate -->
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-xl shadow-lg text-white hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-purple-100 mb-1">Engagement</h3>
                                    <p class="text-3xl font-bold">87%</p>
                                    <p class="text-xs text-purple-200 mt-1">Completion rate</p>
                                </div>
                                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                    <span class="text-2xl">📊</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-xs text-purple-200">
                                    <span class="mr-1">🔥</span>
                                    <span>High engagement</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Kit Codes -->
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-6 rounded-xl shadow-lg text-white hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-orange-100 mb-1">Kit Codes</h3>
                                    <p class="text-3xl font-bold">{{ $totalKitCodes }}</p>
                                    <p class="text-xs text-orange-200 mt-1">Access codes</p>
                                </div>
                                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                    <span class="text-2xl">🔑</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-xs text-orange-200">
                                    <span class="mr-1">⚡</span>
                                    <span>Ready to use</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Bar -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <span class="mr-2">⚡</span>
                            Quick Actions
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <a href="{{ route('admin.modules.create') }}" class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 text-center group">
                                <div class="text-2xl mb-2 group-hover:scale-110 transition-transform">📚</div>
                                <div class="text-sm font-medium text-gray-900">Create Course</div>
                            </a>
                            <a href="{{ route('admin.activities.create') }}" class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 text-center group">
                                <div class="text-2xl mb-2 group-hover:scale-110 transition-transform">🎯</div>
                                <div class="text-sm font-medium text-gray-900">Add Activity</div>
                            </a>
                            <a href="{{ route('admin.kit-codes.create') }}" class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 text-center group">
                                <div class="text-2xl mb-2 group-hover:scale-110 transition-transform">🔑</div>
                                <div class="text-sm font-medium text-gray-900">Generate Codes</div>
                            </a>
                            <a href="{{ route('admin.reports') }}" class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 text-center group">
                                <div class="text-2xl mb-2 group-hover:scale-110 transition-transform">📊</div>
                                <div class="text-sm font-medium text-gray-900">View Reports</div>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Enhanced CRUD Sections -->
                    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Modules CRUD Section -->
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-300">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
                                <div class="flex justify-between items-center">
                                    <h2 class="text-xl font-semibold text-white flex items-center">
                                        <span class="text-2xl mr-3">📚</span>
                                        Course Management
                                    </h2>
                                    <a href="{{ route('admin.modules.index') }}" class="text-blue-100 hover:text-white text-sm font-medium bg-white bg-opacity-20 px-3 py-1 rounded-full transition-colors">
                                        View All →
                                    </a>
                                </div>
                                <p class="text-blue-100 text-sm mt-2">Manage your educational content and courses</p>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    @forelse($recentModules as $module)
                                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100 hover:shadow-md transition-all duration-200">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 shadow-md">
                                                    <span class="text-white font-bold text-sm">
                                                        {{ strtoupper(substr($module->module_name, 0, 2)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">{{ $module->module_name }}</p>
                                                    <p class="text-xs text-gray-600 flex items-center mt-1">
                                                        <span class="mr-1">🎯</span>
                                                        {{ $module->focus_area }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        {{ $module->subActivities->count() }} activities
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $module->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    <span class="w-2 h-2 {{ $module->is_active ? 'bg-green-400' : 'bg-red-400' }} rounded-full mr-1"></span>
                                                    {{ $module->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                                <a href="{{ route('admin.modules.edit', $module) }}" class="text-blue-600 hover:text-blue-800 p-1 rounded-lg hover:bg-blue-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-8">
                                            <div class="text-4xl mb-4">📚</div>
                                            <p class="text-gray-500 font-medium">No courses found</p>
                                            <p class="text-gray-400 text-sm mt-1">Create your first course to get started</p>
                                        </div>
                                    @endforelse
                                </div>
                                <div class="mt-6 pt-4 border-t border-gray-200">
                                    <a href="{{ route('admin.modules.create') }}" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-4 rounded-xl text-center block transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        <span class="mr-2">➕</span>Create New Course
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Activities & Checklists CRUD Section -->
                        <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-300">
                            <div class="bg-gradient-to-r from-orange-500 to-red-500 p-6">
                                <div class="flex justify-between items-center">
                                    <h2 class="text-xl font-semibold text-white flex items-center">
                                        <span class="text-2xl mr-3">🎯</span>
                                        Activity Management
                                    </h2>
                                    <a href="{{ route('admin.activities.index') }}" class="text-orange-100 hover:text-white text-sm font-medium bg-white bg-opacity-20 px-3 py-1 rounded-full transition-colors">
                                        View All →
                                    </a>
                                </div>
                                <p class="text-orange-100 text-sm mt-2">Create engaging activities and learning experiences</p>
                            </div>
                            <div class="p-6">
                                <div class="space-y-3">
                                    @forelse($recentActivities as $activity)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-600 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-white font-bold text-xs">A</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $activity->title }}</p>
                                                    <p class="text-xs text-gray-500">{{ $activity->module->module_name ?? 'No Module' }}</p>
                                                </div>
                                            </div>
                                            <div class="flex space-x-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $activity->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $activity->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                                <a href="{{ route('admin.activities.edit', $activity) }}" class="text-blue-600 hover:text-blue-800">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-gray-500 text-center py-4">No activities found</p>
                                    @endforelse
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <a href="{{ route('admin.activities.create') }}" class="w-full bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded text-center block transition-colors">
                                        ➕ Create New Activity
                                    </a>
                                </div>
                            </div>
                        </div>
                        </div>
                        
                    <!-- Second Row of CRUD Sections -->
                    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Users CRUD Section -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                            <div class="p-6 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                        <span class="text-2xl mr-3">👥</span>
                                        Users Management
                                    </h2>
                                    <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View All →
                                    </a>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-3">
                                    @forelse($recentUsers as $user)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-white font-bold text-xs">{{ substr($user->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                                </div>
                                            </div>
                                            <div class="flex space-x-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                                <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-gray-500 text-center py-4">No users found</p>
                                    @endforelse
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <a href="{{ route('admin.users.create') }}" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center block transition-colors">
                                        ➕ Create New User
                                    </a>
                                </div>
                        </div>
                    </div>
                    
                        <!-- Kit Codes CRUD Section -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                            <div class="p-6 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                        <span class="text-2xl mr-3">🔑</span>
                                        Kit Codes Management
                                    </h2>
                                    <a href="{{ route('admin.kit-codes.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View All →
                                    </a>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-3">
                                    @forelse($recentKitCodes as $kitCode)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-white font-bold text-xs">K</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 font-mono">{{ $kitCode->code }}</p>
                                                    <p class="text-xs text-gray-500">{{ $kitCode->module->module_name ?? 'No Module' }}</p>
                                                </div>
                                            </div>
                                            <div class="flex space-x-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $kitCode->is_used ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ $kitCode->is_used ? 'Used' : 'Available' }}
                                                </span>
                                                <a href="{{ route('admin.kit-codes.edit', $kitCode) }}" class="text-blue-600 hover:text-blue-800">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-gray-500 text-center py-4">No kit codes found</p>
                                    @endforelse
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <a href="{{ route('admin.kit-codes.create') }}" class="w-full bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-center block transition-colors">
                                        ➕ Create New Kit Code
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reports Section -->
                    <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <span class="text-2xl mr-3">📊</span>
                                Reports & Analytics
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <a href="{{ route('admin.reports') }}" class="bg-gray-100 hover:bg-gray-200 p-4 rounded-lg text-center transition-colors">
                                    <div class="text-2xl mb-2">📈</div>
                                    <h3 class="font-medium text-gray-900">General Reports</h3>
                                    <p class="text-sm text-gray-600">View comprehensive system reports</p>
                                </a>
                                <a href="{{ route('admin.reports.usage') }}" class="bg-gray-100 hover:bg-gray-200 p-4 rounded-lg text-center transition-colors">
                                    <div class="text-2xl mb-2">📊</div>
                                    <h3 class="font-medium text-gray-900">Usage Reports</h3>
                                    <p class="text-sm text-gray-600">Track user activity and engagement</p>
                                </a>
                                <a href="{{ route('admin.reports.progress') }}" class="bg-gray-100 hover:bg-gray-200 p-4 rounded-lg text-center transition-colors">
                                    <div class="text-2xl mb-2">🎯</div>
                                    <h3 class="font-medium text-gray-900">Progress Reports</h3>
                                    <p class="text-sm text-gray-600">Monitor learning progress</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Enhanced JavaScript for Thinkific-style interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth animations to statistics cards
            const statCards = document.querySelectorAll('.grid .bg-gradient-to-br');
            statCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Add hover effects to quick action buttons
            const quickActions = document.querySelectorAll('.bg-white.p-4.rounded-lg');
            quickActions.forEach(action => {
                action.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 10px 25px -3px rgba(0, 0, 0, 0.1)';
                });
                
                action.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '';
                });
            });

            // Add pulse animation to engagement rate
            const engagementCard = document.querySelector('.from-purple-500');
            if (engagementCard) {
                setInterval(() => {
                    engagementCard.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        engagementCard.style.transform = 'scale(1)';
                    }, 200);
                }, 3000);
            }

            // Add loading states to all buttons
            document.querySelectorAll('a[href*="create"], a[href*="edit"]').forEach(link => {
                link.addEventListener('click', function() {
                    const originalText = this.textContent;
                    this.textContent = 'Loading...';
                    this.style.opacity = '0.7';
                    
                    // Reset after navigation
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.opacity = '1';
                    }, 1000);
                });
            });
        });
    </script>

    <!-- Enhanced CSS for Thinkific-style animations -->
    <style>
        /* Smooth transitions for all interactive elements */
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Enhanced hover effects */
        .hover\:shadow-xl:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Gradient animations */
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .bg-gradient-to-r {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }
        
        /* Pulse animation for engagement metrics */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Enhanced card shadows */
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        /* Smooth transform animations */
        .transform {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover\:-translate-y-1:hover {
            transform: translateY(-4px);
        }
    </style>
</x-admin-layout>
