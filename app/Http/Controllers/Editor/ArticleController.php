<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::with('issue.volume', 'reviews')
            ->latest();

        // Filter by status if provided
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $articles = $query->paginate(15)->withQueryString();

        // Count per status for tabs
        $counts = [
            'all'                => Article::count(),
            'submitted'          => Article::where('status', 'submitted')->count(),
            'under_review'       => Article::where('status', 'under_review')->count(),
            'revision_requested' => Article::where('status', 'revision_requested')->count(),
            'accepted'           => Article::where('status', 'accepted')->count(),
            'rejected'           => Article::where('status', 'rejected')->count(),
            'published'          => Article::where('status', 'published')->count(),
        ];

        return view('editor.articles.index', compact('articles', 'counts'));
    }

    public function show(Article $article): View
    {
        $article->load('files', 'reviews.reviewer');
        return view('editor.articles.show', compact('article'));
    }

    public function screening(Request $request, Article $article): RedirectResponse
    {
        $request->validate([
            'decision' => 'required|in:accept_for_review,request_correction,reject',
            'remarks'  => 'nullable|string',
        ]);

        $statusMap = [
            'accept_for_review'  => 'under_review',
            'request_correction' => 'revision_requested',
            'reject'             => 'rejected',
        ];

        $article->update(['status' => $statusMap[$request->decision]]);

        // Notify the submitter
        if ($article->submitted_by) {
            Notification::create([
                'user_id' => $article->submitted_by,
                'title'   => 'Manuscript Decision',
                'message' => 'Your manuscript "' . $article->title . '" — Decision: ' . ucfirst(str_replace('_', ' ', $statusMap[$request->decision])),
                'type'    => 'review',
            ]);
        }

        return back()->with('success', 'Decision recorded successfully.');
    }

    public function publish(Request $request, Article $article): RedirectResponse
    {
        $request->validate([
            'issue_id' => 'required|exists:issues,id',
            'doi'      => 'nullable|string|unique:articles,doi,' . $article->id,
            'pages'    => 'nullable|string',
        ]);

        $article->update([
            'issue_id'     => $request->issue_id,
            'doi'          => $request->doi,
            'pages'        => $request->pages,
            'status'       => 'published',
            'published_at' => now(),
        ]);

        // Notify the submitter
        if ($article->submitted_by) {
            Notification::create([
                'user_id' => $article->submitted_by,
                'title'   => 'Article Published',
                'message' => 'Your article "' . $article->title . '" has been published.',
                'type'    => 'publication',
            ]);
        }

        return back()->with('success', 'Article published successfully.');
    }
}
