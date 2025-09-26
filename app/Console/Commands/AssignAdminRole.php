<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class AssignAdminRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:assign-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign admin role to a user by email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }
        
        $adminRole = Role::where('name', 'admin')->first();
        
        if (!$adminRole) {
            $this->error('Admin role not found. Please run the seeder first.');
            return 1;
        }
        
        if ($user->hasRole('admin')) {
            $this->info("User {$user->name} already has admin role.");
            return 0;
        }
        
        $user->assignRole($adminRole);
        
        $this->info("Admin role assigned to {$user->name} ({$user->email}) successfully.");
        
        return 0;
    }
}
