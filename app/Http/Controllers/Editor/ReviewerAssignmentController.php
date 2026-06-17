<?php
namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use App\Models\Review;
use App\Models\Notification;
use Illuminate\Http\Request;

class ReviewerAssignmentController extends Controller
{
    public function index(Article $article)
    {
        $reviewers       = User::whereHas('role', fn($q) => $q->where('name', 'reviewer'))->get();
        $assignedReviews = $article->reviews()->with('reviewer')->get();
        return view('editor.assignments.index', compact('article', 'reviewers', 'assignedReviews'));
    }

    public function assign(Request $request, Article $article)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
            'deadline'    => 'required|date|after:today',
        ]);

        // Max 5 reviewers check
        if ($article->reviews()->count() >= 5) {
            return back()->withErrors(['reviewer_id' => 'Maximum 5 reviewers allowed.']);
        }

        // Prevent duplicate assignment
        $exists = $article->reviews()
                          ->where('reviewer_id', $request->reviewer_id)
                          ->exists();
        if ($exists) {
            return back()->withErrors(['reviewer_id' => 'Reviewer already assigned.']);
        }

        Review::create([
            'article_id'  => $article->id,
            'reviewer_id' => $request->reviewer_id,
            'deadline'    => $request->deadline,
            'status'      => 'pending',
        ]);

        Notification::create([
            'user_id' => $request->reviewer_id,
            'title'   => 'Review Assignment',
            'message' => 'You have been assigned to review "' . $article->title . '".',
            'type'    => 'review',
        ]);

        return back()->with('success', 'Reviewer assigned.');
    }

    public function remove(Article $article, Review $review)
    {
        $review->delete();
        return back()->with('success', 'Reviewer removed.');
    }
}