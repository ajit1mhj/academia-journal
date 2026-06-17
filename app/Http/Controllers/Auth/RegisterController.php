<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8|confirmed',
            'institution' => 'nullable|string|max:255',
            'orcid'       => 'nullable|string|max:50',
            'country'     => 'nullable|string|max:100',
            'phone'       => 'nullable|string|max:20',
        ], [
            'name.required'      => 'Full name is required.',
            'email.unique'       => 'This email is already registered.',
            'password.min'       => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        // Default role = author
        $authorRole = Role::where('name', 'author')->first();

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role_id'     => $authorRole->id,
            'institution' => $request->institution,
            'orcid'       => $request->orcid,
            'country'     => $request->country,
            'phone'       => $request->phone,
            'status'      => 'active',
        ]);

        // Fire registered event (triggers email verification)
        event(new Registered($user));

        // Welcome notification
        Notification::create([
            'user_id' => $user->id,
            'title'   => 'Welcome to Academia Journal',
            'message' => 'Your account has been created successfully. You can now submit manuscripts.',
            'type'    => 'system',
        ]);

        Auth::login($user);

        return redirect()->route('author.dashboard')
            ->with('success', 'Registration successful! Please verify your email.');
    }
}
