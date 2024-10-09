<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\IDGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'errors' => $validator->errors()], 422);
        }

        // If user not approved yet
        $user = User::where('email', $request->email)->first();
        if (in_array($user->approved_by, ['Pending', 'Rejected', null, 'Admin'])) {
            return response()->json(['status' => 0, 'message' => 'Your account is not approved yet.']);
        }

        // Credentials
        $credentials = $request->only('email', 'password');

        // Attempt to login
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json(['status' => 1, 'message' => 'Login successfully.']);
        }

        // Authentication failed
        return response()->json(['status' => 0, 'message' => 'Email or Password not matched.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    public function register(Request $request)
    {
        // Validation rules
        $rules = [
            'role'       => 'required|in:User,Station Manager',
            'first_name' => 'required|string|max:255',
            'surname'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6|confirmed',
            // 'title_id' => 'nullable|integer', // Uncomment if needed
            // 'dob'      => 'nullable|date',    // Uncomment if needed
            // Include other fields if necessary
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ], 422);
        }

        // here I need to choose prefix of if field according to a user role
        $prefix = $request->role === 'User' ? 'US-' : 'SM-';

        // Create the user
        $user = User::create([
            'user_id'    => IDGeneratorService::generateId(User::max('id'), $prefix),
            'first_name' => $request->first_name,
            'surname'  => $request->surname,
            'email'      => $request->email,
            'password'   => Hash::make($request->password), // Use Laravel's Hash for security
            'title_id'   => 0,    // As per your code, title_id is set to '0'
            'dob'        => null, // As per your code, dob is set to null
            'category'    => $request->role,
            // Add other fields as necessary
            'name' => $request->first_name . ' ' . $request->surname,
            'approved_by' => 'Pending',
        ]);

        $roleName = $request->role ?? 'User'; // Default to 'User'
        // Assign the selected role to the user
        $user->assignRole($roleName);

        return response()->json(['status' => 1, 'message' => 'Register successfully.']);
    }
}
