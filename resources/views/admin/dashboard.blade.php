<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Total Users -->
                        <div class="bg-blue-100 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800">Total Users</h3>
                            <p class="text-3xl font-bold text-blue-900">{{ $totalUsers }}</p>
                        </div>
                        
                        <!-- Total Modules -->
                        <div class="bg-green-100 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800">Total Modules</h3>
                            <p class="text-3xl font-bold text-green-900">{{ $totalModules }}</p>
                        </div>
                        
                        <!-- Total Activities -->
                        <div class="bg-yellow-100 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-yellow-800">Total Activities</h3>
                            <p class="text-3xl font-bold text-yellow-900">{{ $totalActivities }}</p>
                        </div>
                        
                        <!-- Total Kit Codes -->
                        <div class="bg-purple-100 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-purple-800">Total Kit Codes</h3>
                            <p class="text-3xl font-bold text-purple-900">{{ $totalKitCodes }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <a href="{{ route('admin.modules.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                                Manage Modules
                            </a>
                            <a href="{{ route('admin.activities.index') }}" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded text-center">
                                Manage Activities
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                                Manage Users
                            </a>
                            <a href="{{ route('admin.kit-codes.index') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-center">
                                Manage Kit Codes
                            </a>
                            <a href="{{ route('admin.reports') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                                View Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
