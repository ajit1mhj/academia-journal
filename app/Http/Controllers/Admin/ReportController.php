<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Issue;
use App\Models\Review;
use App\Models\User;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            // Submissions
            'total_submissions'    => Article::count(),
            'submitted'            => Article::where('status', 'submitted')->count(),
            'under_review'         => Article::where('status', 'under_review')->count(),
            'revision_requested'   => Article::where('status', 'revision_requested')->count(),
            'accepted'             => Article::where('status', 'accepted')->count(),
            'rejected'             => Article::where('status', 'rejected')->count(),
            'published'            => Article::where('status', 'published')->count(),

            // Users
            'total_users'          => User::count(),
            'total_authors'        => User::whereHas('role', fn($q) => $q->where('name', 'author'))->count(),
            'total_reviewers'      => User::whereHas('role', fn($q) => $q->where('name', 'reviewer'))->count(),
            'total_editors'        => User::whereHas('role', fn($q) => $q->where('name', 'editor'))->count(),

            // Reviews
            'total_reviews'        => Review::count(),
            'pending_reviews'      => Review::where('status', 'pending')->count(),
            'submitted_reviews'    => Review::where('status', 'submitted')->count(),
            'overdue_reviews'      => Review::where('status', 'pending')
                                            ->where('deadline', '<', now())
                                            ->count(),

            // Publications
            'total_volumes'        => Volume::count(),
            'total_issues'         => Issue::count(),
            'published_issues'     => Issue::where('status', 'published')->count(),
            'total_views'          => Article::sum('views'),
            'total_downloads'      => Article::sum('downloads'),
        ];

        // Submissions by month (last 12 months)
        $submissionsByMonth = Article::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as total')
                                     ->where('created_at', '>=', now()->subMonths(12))
                                     ->groupByRaw('YEAR(created_at), MONTH(created_at)')
                                     ->orderByRaw('YEAR(created_at), MONTH(created_at)')
                                     ->get()
                                     ->map(fn($row) => [
                                         'label' => date('M Y', mktime(0, 0, 0, $row->month, 1, $row->year)),
                                         'total' => $row->total,
                                     ]);

        // Publications by month (last 12 months)
        $publicationsByMonth = Article::selectRaw('MONTH(published_at) as month, YEAR(published_at) as year, COUNT(*) as total')
                                      ->whereNotNull('published_at')
                                      ->where('published_at', '>=', now()->subMonths(12))
                                      ->groupByRaw('YEAR(published_at), MONTH(published_at)')
                                      ->orderByRaw('YEAR(published_at), MONTH(published_at)')
                                      ->get()
                                      ->map(fn($row) => [
                                          'label' => date('M Y', mktime(0, 0, 0, $row->month, 1, $row->year)),
                                          'total' => $row->total,
                                      ]);

        // Top articles by views
        $topArticles = Article::where('status', 'published')
                               ->orderByDesc('views')
                               ->take(10)
                               ->get(['id', 'title', 'views', 'downloads']);

        // Submissions by subject area
        $bySubjectArea = Article::selectRaw('subject_area, COUNT(*) as total')
                                 ->whereNotNull('subject_area')
                                 ->groupBy('subject_area')
                                 ->orderByDesc('total')
                                 ->take(10)
                                 ->get();

        return view('admin.reports.index', compact(
            'stats',
            'submissionsByMonth',
            'publicationsByMonth',
            'topArticles',
            'bySubjectArea'
        ));
    }

    public function submissions(Request $request)
    {
        $query = Article::with('authors')
                        ->orderByDesc('created_at');

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        if ($request->filled('subject_area')) {
            $query->where('subject_area', 'like', '%' . $request->subject_area . '%');
        }

        $articles = $query->paginate(20)->withQueryString();

        $statusCounts = Article::selectRaw('status, COUNT(*) as total')
                                ->groupBy('status')
                                ->pluck('total', 'status');

        return view('admin.reports.submissions', compact('articles', 'statusCounts'));
    }

    public function publications(Request $request)
    {
        $query = Article::where('status', 'published')
                        ->with('authors', 'issue.volume')
                        ->orderByDesc('published_at');

        if ($request->filled('from')) {
            $query->whereDate('published_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('published_at', '<=', $request->to);
        }

        $articles  = $query->paginate(20)->withQueryString();

        $volumes   = Volume::with('issues')->orderByDesc('year')->get();

        return view('admin.reports.publications', compact('articles', 'volumes'));
    }

    public function users(Request $request)
    {
        $query = User::with('role')->orderByDesc('created_at');

        if ($request->filled('role')) {
            $query->whereHas('role', fn($q) => $q->where('name', $request->role));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        $users = $query->paginate(20)->withQueryString();

        $roleCounts = User::join('roles', 'users.role_id', '=', 'roles.id')
                          ->selectRaw('roles.name as role, COUNT(*) as total')
                          ->groupBy('roles.name')
                          ->pluck('total', 'role');

        return view('admin.reports.users', compact('users', 'roleCounts'));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'submissions');

        $filename = $type . '_report_' . now()->format('Y_m_d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = match($type) {
            'submissions'  => fn() => $this->exportSubmissions(),
            'publications' => fn() => $this->exportPublications(),
            'users'        => fn() => $this->exportUsers(),
            'reviews'      => fn() => $this->exportReviews(),
            default        => fn() => $this->exportSubmissions(),
        };

        return response()->stream($callback, 200, $headers);
    }

    // ─── Private Export Helpers ──────────────────────────────────

    private function exportSubmissions(): void
    {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, [
            'ID', 'Title', 'Authors', 'Subject Area',
            'Status', 'Submitted Date', 'Published Date', 'DOI'
        ]);

        Article::with('authors')->orderByDesc('created_at')
               ->chunk(100, function ($articles) use ($handle) {
                   foreach ($articles as $article) {
                       fputcsv($handle, [
                           $article->id,
                           $article->title,
                           $article->authors->pluck('name')->implode('; '),
                           $article->subject_area,
                           $article->status,
                           $article->created_at->format('d M Y'),
                           $article->published_at?->format('d M Y') ?? '—',
                           $article->doi ?? '—',
                       ]);
                   }
               });

        fclose($handle);
    }

    private function exportPublications(): void
    {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, [
            'ID', 'Title', 'Authors', 'DOI',
            'Volume', 'Issue', 'Pages',
            'Published Date', 'Views', 'Downloads'
        ]);

        Article::where('status', 'published')
               ->with('authors', 'issue.volume')
               ->orderByDesc('published_at')
               ->chunk(100, function ($articles) use ($handle) {
                   foreach ($articles as $article) {
                       fputcsv($handle, [
                           $article->id,
                           $article->title,
                           $article->authors->pluck('name')->implode('; '),
                           $article->doi ?? '—',
                           $article->issue?->volume->volume_no ?? '—',
                           $article->issue?->issue_no ?? '—',
                           $article->pages ?? '—',
                           $article->published_at?->format('d M Y'),
                           $article->views,
                           $article->downloads,
                       ]);
                   }
               });

        fclose($handle);
    }

    private function exportUsers(): void
    {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, [
            'ID', 'Name', 'Email', 'Role',
            'Institution', 'Country', 'Status', 'Joined'
        ]);

        User::with('role')
            ->orderByDesc('created_at')
            ->chunk(100, function ($users) use ($handle) {
                foreach ($users as $user) {
                    fputcsv($handle, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->role?->name,
                        $user->institution ?? '—',
                        $user->country ?? '—',
                        $user->status,
                        $user->created_at->format('d M Y'),
                    ]);
                }
            });

        fclose($handle);
    }

    private function exportReviews(): void
    {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, [
            'ID', 'Article Title', 'Reviewer',
            'Status', 'Recommendation', 'Deadline', 'Submitted At'
        ]);

        Review::with('article', 'reviewer')
              ->orderByDesc('created_at')
              ->chunk(100, function ($reviews) use ($handle) {
                  foreach ($reviews as $review) {
                      fputcsv($handle, [
                          $review->id,
                          $review->article->title,
                          $review->reviewer->name,
                          $review->status,
                          $review->recommendation ?? '—',
                          $review->deadline?->format('d M Y') ?? '—',
                          $review->submitted_at?->format('d M Y H:i') ?? '—',
                      ]);
                  }
              });

        fclose($handle);
    }
}