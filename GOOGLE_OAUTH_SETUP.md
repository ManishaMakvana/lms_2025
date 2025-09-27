# Google OAuth Authentication Setup

## Environment Configuration

Add the following variables to your `.env` file:

```env
# Google OAuth Configuration
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

## Features Implemented

### 1. Google OAuth Authentication
- Users can login with their Google accounts
- Automatic user creation for new Google users
- Existing users can link their Google accounts
- Google profile picture is stored as avatar

### 2. Role and Permission System
- **Admin Role**: Full system access
- **User Role**: Basic user access
- Permissions include:
  - `manage_users` - Create, edit, delete users
  - `manage_roles` - Manage user roles
  - `manage_permissions` - Manage permissions
  - `view_admin_dashboard` - Access admin dashboard
  - `manage_courses` - Manage learning courses
  - `enroll_courses` - Enroll in courses
  - `view_courses` - View available courses

### 3. Middleware Protection
- `role:admin` - Restricts access to admin users only
- `permission:permission_name` - Restricts access based on specific permissions

## Usage

### Assign Admin Role
To assign admin role to a user:
```bash
php artisan user:assign-admin user@example.com
```

### Using Middleware in Routes
```php
// Admin only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

// Permission-based routes
Route::middleware(['auth', 'permission:manage_users'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
});
```

### Checking Roles and Permissions in Code
```php
// Check if user has role
if (auth()->user()->hasRole('admin')) {
    // Admin logic
}

// Check if user has permission
if (auth()->user()->hasPermission('manage_users')) {
    // Permission logic
}

// Check if user is admin
if (auth()->user()->isAdmin()) {
    // Admin logic
}
```

## Routes

### Authentication Routes
- `GET /auth/google` - Redirect to Google OAuth
- `GET /auth/google/callback` - Handle Google OAuth callback

### Admin Routes
- `GET /admin` - Admin dashboard (admin only)
- `GET /admin/users` - User management (admin only)

## Database Structure

### Tables Created
- `roles` - User roles (admin, user)
- `permissions` - System permissions
- `role_user` - Many-to-many relationship between users and roles
- `permission_role` - Many-to-many relationship between roles and permissions

### User Table Updates
- `google_id` - Google OAuth ID
- `avatar` - User avatar URL

## Setup Instructions

1. Run migrations:
```bash
php artisan migrate
```

2. Seed roles and permissions:
```bash
php artisan db:seed --class=RolePermissionSeeder
```

3. Assign admin role to a user:
```bash
php artisan user:assign-admin your-email@example.com
```

4. Start the development server:
```bash
php artisan serve
```

5. Visit `http://127.0.0.1:8000/login` and click "Continue with Google"

## Security Notes

- Google OAuth credentials should be obtained from Google Console
- Make sure to update the redirect URI in Google Console if needed
- Admin routes are protected by role middleware
- All authentication is handled securely through Laravel Socialite
