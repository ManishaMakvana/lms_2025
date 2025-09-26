<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit User') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $user->name) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', $user->email) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">New Password (Leave blank to keep current)</label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role" 
                                        id="role" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Student</option>
                                    <option value="trainer" {{ old('role', $user->role) == 'trainer' ? 'selected' : '' }}>Trainer</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Google ID (Optional) -->
                            <div>
                                <label for="google_id" class="block text-sm font-medium text-gray-700">Google ID (Optional)</label>
                                <input type="text" 
                                       name="google_id" 
                                       id="google_id" 
                                       value="{{ old('google_id', $user->google_id) }}"
                                       placeholder="Leave empty for email login only"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('google_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Avatar URL (Optional) -->
                            <div class="md:col-span-2">
                                <label for="avatar" class="block text-sm font-medium text-gray-700">Avatar URL (Optional)</label>
                                <input type="url" 
                                       name="avatar" 
                                       id="avatar" 
                                       value="{{ old('avatar', $user->avatar) }}"
                                       placeholder="https://example.com/avatar.jpg"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('avatar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
