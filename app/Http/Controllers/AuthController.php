<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;


class AuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
{
    
    $user = Socialite::driver($provider)->user();

    // Check if a user with this email already exists
    $existingUser = User::where('email', $user->getEmail())->first();

    if ($existingUser) {
        // Log in the existing user
        Auth::login($existingUser);
    } else {
        // Create a new user
        $newUser = User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => Hash::make(Str::random(24)), // Dummy password
        ]);

        Auth::login($newUser);
    }

    return redirect('/snake'); // Redirect to the dashboard after login
}
}