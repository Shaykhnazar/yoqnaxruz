<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Show User Profile
    public function showProfile()
    {
        return view('userprofile');
    }

    // Update User Profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validation rules
        $rules = [
            'first_name' => 'required|string|max:255',
            'surname'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'photo'      => 'nullable|image|max:2048', // Max 2MB
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

        // Update user data
        $user->first_name = $request->first_name;
        $user->surname  = $request->surname;
        $user->email      = $request->email;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('uploads/user', 'public');
            $user->photo = $photoPath;
        }

        $user->save();

        return response()->json(['status' => 1, 'message' => 'Profile updated successfully.']);
    }

    // Reset User Password
    public function resetPassword(Request $request)
    {
        $user = Auth::user();

        // Validation rules
        $rules = [
            'opass' => 'required',
            'npass' => 'required|min:6',
            'cpass' => 'required|same:npass',
        ];

        // Custom error messages
        $messages = [
            'cpass.same' => 'The confirmation password does not match.',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if old password matches
        if (!Hash::check($request->opass, $user->password)) {
            return response()->json([
                'status' => 0,
                'errors' => ['opass' => ['Old password is incorrect.']]
            ], 422);
        }

        // Update password
        $user->password = Hash::make($request->npass);
        $user->save();

        return response()->json(['status' => 1, 'message' => 'Password reset successfully.']);
    }
}
