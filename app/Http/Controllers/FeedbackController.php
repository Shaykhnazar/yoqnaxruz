<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Session;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'station' => 'required|exists:stations,id',
            'comment' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB
        ]);

        $attachmentPath = '';
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('uploads/feedback', 'public');
        }

        Feedback::create([
            'station_id' => $request->station,
            'user_id' => Session::get('user_id'),
            'title' => $request->title,
            'comment' => $request->comment,
            'user_rating' => $request->rating,
            'attachment' => $attachmentPath,
        ]);

        return response()->json(['message' => 'Feedback successfully submitted.']);
    }
}
