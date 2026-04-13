<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(20);

        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function approve(Request $request, Feedback $feedback)
    {
        $feedback->update(['is_approved' => true]);

        return redirect()->route('admin.feedbacks.index')->with('success', 'Feedback approved and visible on the site.');
    }

    public function unapprove(Request $request, Feedback $feedback)
    {
        $feedback->update(['is_approved' => false]);

        return redirect()->route('admin.feedbacks.index')->with('success', 'Feedback hidden from the site.');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('admin.feedbacks.index')->with('success', 'Feedback deleted.');
    }
}
