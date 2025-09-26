<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect to Google OAuth provider.
     */
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            \Log::error('Google OAuth redirect error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Google authentication is currently unavailable. Please try again later.');
        }
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // Update Google ID if not set
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
                
                // Update avatar if not set
                if (!$user->avatar) {
                    $user->update(['avatar' => $googleUser->getAvatar()]);
                }
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                ]);

                // Assign default user role
                $userRole = Role::where('name', 'user')->first();
                if ($userRole) {
                    $user->assignRole($userRole);
                }
            }

            // Login the user
            Auth::login($user);

            return redirect()->intended('/dashboard');
            
        } catch (\Exception $e) {
            \Log::error('Google OAuth callback error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Something went wrong with Google authentication: ' . $e->getMessage());
        }
    }
}
