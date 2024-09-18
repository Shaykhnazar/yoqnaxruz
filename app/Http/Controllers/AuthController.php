<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Session::put('user_id', $user->id);
            Session::put('role_id', $user->role_id);
            Session::put('first_name', $user->first_name);
            Session::put('email', $user->email);

            return response()->json(['status' => 1, 'message' => 'Login successfully.']);
        }

        return response()->json(['status' => 0, 'message' => 'Email or Password not matched.']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id', // Assuming you have a roles table
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'role_id' => $request->role_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Registered successfully.']);
    }
}
