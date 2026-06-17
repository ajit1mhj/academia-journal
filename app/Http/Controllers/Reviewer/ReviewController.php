<?php
namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $reviews = Review::where('reviewer_id', Auth::id())
                         ->with('article')
                         ->latest()
                         ->paginate(10);

        return view('reviewer.reviews.index', compact('reviews'));
    }

    public function show(Review $review): View
    {
        // Manual ownership check instead of Policy
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'You are not assigned to this review.');
        }

        $review->load('article.files', 'article.authors');

        return view('reviewer.reviews.show', compact('review'));
    }

    public function submit(Request $request, Review $review): RedirectResponse
    {
        // Manual ownership check
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'You are not assigned to this review.');
        }

        // Prevent resubmission
        if ($review->status === 'submitted') {
            return back()->withErrors(['error' => 'This review has already been submitted.']);
        }

        $request->validate([
            'strengths'       => 'required|string',
            'weaknesses'      => 'required|string',
            'comments_author' => 'required|string',
            'comments_editor' => 'nullable|string',
            'recommendation'  => 'required|in:accept,minor_revision,major_revision,reject',
            'review_file'     => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->only([
            'strengths',
            'weaknesses',
            'comments_author',
            'comments_editor',
            'recommendation',
        ]);

        $data['status']       = 'submitted';
        $data['submitted_at'] = now();

        if ($request->hasFile('review_file')) {
            $data['review_file'] = $request->file('review_file')
                                           ->store('reviews', 'private');
        }

        $review->update($data);

        // Reload article to get fresh data
        $review->load('article.reviews');

        // Check if minimum 2 reviews submitted — notify editor
        $submittedCount = $review->article
                                 ->reviews()
                                 ->where('status', 'submitted')
                                 ->count();

        // Notify all editors dynamically (not hardcoded id)
        $editors = User::whereHas('role', fn($q) => $q->whereIn('name', ['editor', 'admin']))
                       ->get();

        foreach ($editors as $editor) {
            Notification::create([
                'user_id' => $editor->id,
                'title'   => 'Review Submitted',
                'message' => 'A review has been submitted for "' . $review->article->title . '" by ' . Auth::user()->name . '.',
                'type'    => 'review',
            ]);
        }

        // If 2+ reviews done, update article status to ready for decision
        if ($submittedCount >= 2) {
            $review->article->update(['status' => 'under_review']);
        }

        return redirect()->route('reviewer.reviews.index')
                         ->with('success', 'Review submitted successfully.');
    }
}