<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Users
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- User Information -->
                        <div class="lg:col-span-2">
                            <div class="flex items-center mb-6">
                                @if($user->avatar)
                                    <img class="h-16 w-16 rounded-full" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-2xl font-medium text-gray-700">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                                    <p class="text-gray-600">{{ $user->email }}</p>
                                    @if($user->id === auth()->id())
                                        <span class="text-sm text-blue-600">(You)</span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <h3 class="text-lg font-semibold mb-2">Account Information</h3>
                                    <div class="space-y-2">
                                        <div>
                                            <span class="font-medium text-gray-800">Role:</span>
                                            @if($user->role === 'admin')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    Admin
                                                </span>
                                            @elseif($user->role === 'trainer')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Trainer
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Student
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-800">Login Type:</span>
                                            @if($user->google_id)
                                                <span class="text-gray-600">Google OAuth</span>
                                            @else
                                                <span class="text-gray-600">Email/Password</span>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-800">Joined:</span>
                                            <span class="text-gray-600">{{ $user->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-800">Last Updated:</span>
                                            <span class="text-gray-600">{{ $user->updated_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold mb-2">Activity Statistics</h3>
                                    <div class="space-y-2">
                                        <div>
                                            <span class="font-medium text-gray-800">Unlocked Modules:</span>
                                            <span class="text-2xl font-bold text-blue-600">{{ $user->unlockedModules->count() }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-800">Activity Progress:</span>
                                            <span class="text-2xl font-bold text-green-600">{{ $user->activityProgress->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                                
                                <div class="space-y-3">
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.toggle-role', $user) }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-center"
                                                    onclick="return confirm('Are you sure you want to change this user\'s role?')">
                                                {{ $user->role === 'admin' ? 'Make Student' : 'Make Admin' }}
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center block">
                                        Edit User
                                    </a>
                                    
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                              onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center">
                                                Delete User
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Unlocked Modules Section -->
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold mb-4">Unlocked Modules</h3>
                        @if($user->unlockedModules->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($user->unlockedModules as $module)
                                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-gray-800">{{ $module->module_name }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($module->description, 80) }}</p>
                                        <div class="mt-2">
                                            <span class="text-xs text-gray-500">
                                                Unlocked: {{ $module->pivot->unlocked_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No modules unlocked yet.</p>
                        @endif
                    </div>

                    <!-- Activity Progress Section -->
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold mb-4">Activity Progress</h3>
                        @if($user->activityProgress->count() > 0)
                            <div class="space-y-4">
                                @foreach($user->activityProgress as $progress)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-semibold text-gray-800">{{ $progress->subActivity->title }}</h4>
                                                <p class="text-sm text-gray-600">{{ $progress->subActivity->module->module_name }}</p>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-2xl font-bold text-blue-600">{{ $progress->progress_percent }}%</div>
                                                <div class="w-32 bg-gray-200 rounded-full h-2 mt-1">
                                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progress->progress_percent }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No activity progress recorded yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
