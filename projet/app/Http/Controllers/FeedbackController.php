<?php

namespace App\Http\Controllers;
use App\Models\Registration;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function show($token) {
        $registration = Registration::where('feedback_token', $token)->firstOrFail();
        $event = $registration->event;
        
        return view('events.feedback', compact('registration', 'event'));
    }

    public function store(Request $request, $token) {
        $registration = Registration::where('feedback_token', $token)->firstOrFail();
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $registration->update([
            'feedback_rating' => $request->rating,
            'feedback_comment' => $request->comment,
            'feedback_token' => null, 
        ]);

        return redirect()->route('events.index')->with('success', 'Merci pour votre avis !');
    }
}