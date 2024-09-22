<?php

namespace App\Http\Controllers;

use App\Models\ComplaintReply;
use App\Models\Station;
use App\Services\IDGeneratorService;
use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    // List complaints made by the current user
    public function index()
    {
        $complaints = Complaint::with('replies', 'user')->where('user_id', Auth::user()->user_id)->get();
        return view('complaints.index', compact('complaints'));
    }

    // Display form to create a new complaint
    public function create()
    {
        return view('complaints.create');
    }

    // Store a newly created complaint in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
            'status' => 'nullable|string',
            'station_id' => 'required|string|max:255',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB
        ]);

        $attachmentPath = '';
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('uploads/complaints', 'public');
        }

        Complaint::create([
            'complaint_id' => IDGeneratorService::generateId(Complaint::max('id'), 'COMP_'),
            'date_logged' => now(),
            'time' => now()->format('H:i:s'),
            'user_id' => Auth::user()->user_id,
            'station_id' => $request->station_id,
            'complainant' => $request->comment,
            'status' => $request->status ?? 'pending',
            'display' => true,
            'attachments' => $attachmentPath,
        ]);

        return redirect()->route('complaints.index')->with('success', 'Complaint successfully submitted.');
    }

    // Handle reply submission
    public function reply(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $complaint = Complaint::findOrFail($id);

        ComplaintReply::create([
            'complaint_id' => $complaint->complaint_id,
            'user_id' => Auth::user()->user_id,
            'comment' => $request->input('comment'),
            'date' => now(),
            'reply_by' => 'User', // Adjust based on the role
        ]);

        return redirect()->back()->with('success', 'Replied successfully.');
    }

}
