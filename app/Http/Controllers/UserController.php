<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Show User Profile
    public function dashboard()
    {
        return view('dashboard');
    }

    public function showProfile()
    {
        return view('userprofile', ['authUser' => Auth::user()]);
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
            'date_of_birth' => 'nullable|date',
            'phone1' => 'nullable|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'street_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:10',
            'photo'      => 'nullable|image|max:2048', // Max 2MB
            'make' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'rego' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:255',
        ];

        // Define custom validation messages
        $messages = [
            'role.required' => 'Role is required.',
            'role.in' => 'Invalid role selected.',
            'first_name.required' => 'First name is required.',
            'surname.required' => 'Surname is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already taken.',
            'photo.image' => 'Profile photo must be an image.',
            'photo.mimes' => 'Profile photo must be a file of type: jpg, jpeg, png.',
            'photo.max' => 'Profile photo may not be greater than 2MB.',
            'station_id.required' => 'Station ID is required for Station Managers.',
            'station_id.string' => 'Station ID must be a string.',
            'station_id.max' => 'Station ID cannot exceed 255 characters.',
            'station_name.required' => 'Station Name is required for Station Managers.',
            'station_name.string' => 'Station Name must be a string.',
            'station_name.max' => 'Station Name cannot exceed 255 characters.',
        ];

        // Validate the incoming request data
        $validator = Validator::make($request->all(), $rules, $messages);


        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update($request->except('photo'));

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('uploads/user', 'public');
            $user->update(['photo' => $photoPath]);
        }

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
