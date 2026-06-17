<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleFile;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    public function index(): View
    {
        $articles = Article::where('submitted_by', Auth::id())
            ->with('issue.volume')
            ->latest()
            ->paginate(10);

        return view('author.submissions.index', compact('articles'));
    }

    public function create(): View
    {
        return view('author.submissions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'           => 'required|string|max:500',
            'authors'         => 'required|string|max:500',
            'abstract'        => 'nullable|string',
            'keywords'        => 'nullable|string',
            'subject_area'    => 'nullable|string',
            'language'        => 'required|string',
            'manuscript'      => 'required|file|mimes:pdf,doc,docx,zip|max:20480',
            'cover_letter'    => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'copyright_form'  => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'agree_original'  => 'accepted',
            'agree_ethics'    => 'accepted',
            'agree_copyright' => 'accepted',
        ]);

        DB::transaction(function () use ($request) {

            $article = Article::create([
                ...$request->only([
                    'title',
                    'authors',
                    'abstract',
                    'keywords',
                    'subject_area',
                    'language',
                ]),
                'submitted_by' => Auth::id(),
            ]);

            // Store uploaded files
            $fileTypes = ['manuscript', 'cover_letter', 'copyright_form'];
            foreach ($fileTypes as $type) {
                if ($request->hasFile($type)) {
                    $path = $request->file($type)->store('submissions', 'private');
                    ArticleFile::create([
                        'article_id'    => $article->id,
                        'file_type'     => $type,
                        'file_path'     => $path,
                        'original_name' => $request->file($type)->getClientOriginalName(),
                        'version'       => 1,
                    ]);
                }
            }

            // Notify submitting author
            Notification::create([
                'user_id' => Auth::id(),
                'title'   => 'Submission Received',
                'message' => 'Your manuscript "' . $article->title . '" has been received successfully.',
                'type'    => 'submission',
            ]);

            // Notify all editors
            $editors = User::whereHas('role', fn($q) => $q->whereIn('name', ['editor', 'admin']))
                ->get();

            foreach ($editors as $editor) {
                Notification::create([
                    'user_id' => $editor->id,
                    'title'   => 'New Manuscript Submitted',
                    'message' => 'A new manuscript "' . $article->title . '" has been submitted.',
                    'type'    => 'submission',
                ]);
            }
        });

        return redirect()->route('author.submissions.index')
            ->with('success', 'Manuscript submitted successfully.');
    }

    public function show(Article $article): View
    {
        // Manual ownership check
        if ($article->submitted_by !== Auth::id()) {
            abort(403, 'You do not have permission to view this submission.');
        }

        $article->load('files', 'reviews');

        return view('author.submissions.show', compact('article'));
    }

    public function uploadRevision(Request $request, Article $article): RedirectResponse
    {
        // Ownership check
        if ($article->submitted_by !== Auth::id()) {
            abort(403, 'You do not have permission to revise this submission.');
        }

        // Only allow revision if status is revision_requested
        if ($article->status !== 'revision_requested') {
            return back()->withErrors([
                'error' => 'Revision can only be uploaded when a revision has been requested.'
            ]);
        }

        $request->validate([
            'revised_manuscript'    => 'required|file|mimes:pdf,doc,docx|max:20480',
            'response_to_reviewers' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // Get next version number
        $version = $article->files()
            ->where('file_type', 'manuscript')
            ->max('version') + 1;

        // Store revised manuscript
        $manuscriptPath = $request->file('revised_manuscript')
            ->store('submissions', 'private');

        ArticleFile::create([
            'article_id'    => $article->id,
            'file_type'     => 'revised',
            'file_path'     => $manuscriptPath,
            'original_name' => $request->file('revised_manuscript')->getClientOriginalName(),
            'version'       => $version,
        ]);

        // Store response to reviewers
        $responsePath = $request->file('response_to_reviewers')
            ->store('submissions', 'private');

        ArticleFile::create([
            'article_id'    => $article->id,
            'file_type'     => 'supplementary',
            'file_path'     => $responsePath,
            'original_name' => $request->file('response_to_reviewers')->getClientOriginalName(),
            'version'       => $version,
        ]);

        $article->update(['status' => 'under_review']);

        // Notify editors about revision
        $editors = User::whereHas('role', fn($q) => $q->whereIn('name', ['editor', 'admin']))
            ->get();

        foreach ($editors as $editor) {
            Notification::create([
                'user_id' => $editor->id,
                'title'   => 'Revision Submitted',
                'message' => 'A revised manuscript has been submitted for "' . $article->title . '".',
                'type'    => 'submission',
            ]);
        }

        return back()->with('success', 'Revision uploaded successfully.');
    }
}
