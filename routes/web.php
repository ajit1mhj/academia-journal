<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Controllers - Public
use App\Http\Controllers\Public\ArchiveController;
use App\Http\Controllers\Public\ArticleController as PublicArticleController;

// Controllers - Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;

// Controllers - Admin
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\VolumeController;
use App\Http\Controllers\Admin\IssueController;
use App\Http\Controllers\Admin\EditorialBoardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\CmsController;

// Controllers - Editor
use App\Http\Controllers\Editor\ArticleController as EditorArticleController;
use App\Http\Controllers\Editor\ReviewerAssignmentController;

// Controllers - Author
use App\Http\Controllers\Author\SubmissionController;

// Controllers - Reviewer
use App\Http\Controllers\Reviewer\ReviewController;

// Controllers - Shared
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/about', function () {
    return view('public.about');
})->name('about');

Route::get('/editorial-board', function () {
    return view('public.editorial-board');
})->name('editorial-board');

Route::get('/contact', function () {
    return view('public.contact');
})->name('contact');

Route::get('/publication-ethics', function () {
    return view('public.publication-ethics');
})->name('publication-ethics');

// Individual issue page — e.g. /volume-1/issue-1
Route::get('/volume-{volumeNo}/issue-{issueNo}', [
    \App\Http\Controllers\Public\IssueController::class, 'show'
])->name('issue.show');

Route::get('/current-issue', [
    \App\Http\Controllers\Public\IssueController::class, 'current'
])->name('current-issue');

Route::get('/current-issue', function () {
    $issueId = request('issue');

    if ($issueId) {
        $issue = \App\Models\Issue::where('id', $issueId)
            ->with([
                'volume',
                'articles.authors',
                'articles.files', // ← must include files
            ])
            ->first();
    } else {
        $issue = \App\Models\Issue::where('status', 'published')
            ->with([
                'volume',
                'articles.authors',
                'articles.files', // ← must include files
            ])
            ->latest('publication_date')
            ->first();
    }

    return view('public.current-issue', compact('issue'));
})->name('current-issue');

Route::get('/archives', [ArchiveController::class, 'index'])->name('archives');

Route::prefix('articles')->name('articles.')->group(function () {
    Route::get('/{article}',          [PublicArticleController::class, 'show'])->name('show');
    Route::get('/{article}/download', [PublicArticleController::class, 'download'])->name('download');
});

/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login',   [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',  [LoginController::class, 'login'])->name('login.post');

    Route::get('/register',  [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    Route::get('/forgot-password',    [LoginController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password',   [LoginController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password',    [LoginController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'status'])->group(function () {

    // Email Verification
    Route::get('/email/verify', [VerificationController::class, 'notice'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/resend', [VerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.resend');

    // Dashboard — redirect based on role
    Route::get('/dashboard', function () {
        /** @var User $user */
        $user = Auth::user();
        $role = $user->role->name;

        return match ($role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'editor'   => redirect()->route('editor.dashboard'),
            'reviewer' => redirect()->route('reviewer.dashboard'),
            'author'   => redirect()->route('author.dashboard'),
            default    => redirect()->route('home'),
        };
    })->name('dashboard');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/',         [ProfileController::class, 'show'])->name('show');
        Route::get('/edit',     [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update',   [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
        Route::delete('/photo', [ProfileController::class, 'removePhoto'])->name('photo.remove');
    });

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/',                        [NotificationController::class, 'index'])->name('index');
        Route::put('/{notification}/read',     [NotificationController::class, 'markRead'])->name('read');
        Route::put('/mark-all-read',           [NotificationController::class, 'markAllRead'])->name('read-all');
        Route::delete('/{notification}',       [NotificationController::class, 'destroy'])->name('destroy');
    });

    /*
    |----------------------------------------------------------------------
    | ADMIN ROUTES
    |----------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', function () {
            $stats = [
                'total_users'       => \App\Models\User::count(),
                'total_submissions' => \App\Models\Article::count(),
                'published'         => \App\Models\Article::where('status', 'published')->count(),
                'under_review'      => \App\Models\Article::where('status', 'under_review')->count(),
            ];
            return view('admin.dashboard', compact('stats'));
        })->name('dashboard');

        Route::resource('users', UserController::class);
        Route::put('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');

        Route::resource('journals', JournalController::class);
        Route::resource('volumes',  VolumeController::class);
        Route::resource('issues',   IssueController::class);
        Route::resource('editorial-board', EditorialBoardController::class);

        Route::post('editorial-board/reorder', [EditorialBoardController::class, 'reorder'])
            ->name('editorial-board.reorder');

        Route::prefix('cms')->name('cms.')->group(function () {
            Route::get('/',            [CmsController::class, 'index'])->name('index');
            Route::get('/{page}/edit', [CmsController::class, 'edit'])->name('edit');
            Route::put('/{page}',      [CmsController::class, 'update'])->name('update');
        });

        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/',             [ReportController::class, 'index'])->name('index');
            Route::get('/submissions',  [ReportController::class, 'submissions'])->name('submissions');
            Route::get('/publications', [ReportController::class, 'publications'])->name('publications');
            Route::get('/users',        [ReportController::class, 'users'])->name('users');
            Route::get('/export',       [ReportController::class, 'export'])->name('export');
        });
    });

    /*
    |----------------------------------------------------------------------
    | EDITOR ROUTES
    |----------------------------------------------------------------------
    */
    Route::middleware('role:admin,editor')->prefix('editor')->name('editor.')->group(function () {

        Route::get('/dashboard', function () {
            $stats = [
                'new_submissions' => \App\Models\Article::where('status', 'submitted')->count(),
                'under_review'    => \App\Models\Article::where('status', 'under_review')->count(),
                'accepted'        => \App\Models\Article::where('status', 'accepted')->count(),
                'rejected'        => \App\Models\Article::where('status', 'rejected')->count(),
            ];
            return view('editor.dashboard', compact('stats'));
        })->name('dashboard');

        Route::prefix('articles')->name('articles.')->group(function () {
            Route::get('/',                     [EditorArticleController::class, 'index'])->name('index');
            Route::get('/{article}',            [EditorArticleController::class, 'show'])->name('show');
            Route::post('/{article}/screening', [EditorArticleController::class, 'screening'])->name('screening');
            Route::post('/{article}/publish',   [EditorArticleController::class, 'publish'])->name('publish');
        });

        Route::prefix('assignments')->name('assignments.')->group(function () {
            Route::get('/{article}',             [ReviewerAssignmentController::class, 'index'])->name('index');
            Route::post('/{article}/assign',     [ReviewerAssignmentController::class, 'assign'])->name('assign');
            Route::delete('/{article}/{review}', [ReviewerAssignmentController::class, 'remove'])->name('remove');
        });

        Route::resource('issues', IssueController::class)->except(['destroy']);
    });

    /*
    |----------------------------------------------------------------------
    | AUTHOR ROUTES
    |----------------------------------------------------------------------
    */
    Route::middleware('role:author,admin')->prefix('author')->name('author.')->group(function () {

        Route::get('/dashboard', function () {
            /** @var User $user */
            $user = Auth::user();
            $stats = [
                ['label' => 'Total Submissions', 'value' => $user->articles()->count()],
                ['label' => 'Under Review',      'value' => $user->articles()->where('status', 'under_review')->count()],
                ['label' => 'Accepted',          'value' => $user->articles()->where('status', 'accepted')->count()],
                ['label' => 'Published',         'value' => $user->articles()->where('status', 'published')->count()],
            ];
            return view('author.dashboard', compact('stats'));
        })->name('dashboard');

        Route::prefix('submissions')->name('submissions.')->group(function () {
            Route::get('/',                    [SubmissionController::class, 'index'])->name('index');
            Route::get('/create',              [SubmissionController::class, 'create'])->name('create');
            Route::post('/',                   [SubmissionController::class, 'store'])->name('store');
            Route::get('/{article}',           [SubmissionController::class, 'show'])->name('show');
            Route::post('/{article}/revision', [SubmissionController::class, 'uploadRevision'])->name('revision');
        });
    });

    /*
    |----------------------------------------------------------------------
    | REVIEWER ROUTES
    |----------------------------------------------------------------------
    */
    Route::middleware('role:reviewer,admin')->prefix('reviewer')->name('reviewer.')->group(function () {

        Route::get('/dashboard', function () {
            /** @var User $user */
            $user = Auth::user();
            $stats = [
                ['label' => 'Assigned',  'value' => $user->reviews()->where('status', 'pending')->count()],
                ['label' => 'Completed', 'value' => $user->reviews()->where('status', 'submitted')->count()],
                ['label' => 'Pending',   'value' => $user->reviews()->where('status', 'pending')->count()],
                ['label' => 'Overdue',   'value' => $user->reviews()->where('status', 'pending')->where('deadline', '<', now())->count()],
            ];
            return view('reviewer.dashboard', compact('stats'));
        })->name('dashboard');

        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/',                 [ReviewController::class, 'index'])->name('index');
            Route::get('/{review}',         [ReviewController::class, 'show'])->name('show');
            Route::post('/{review}/submit', [ReviewController::class, 'submit'])->name('submit');
        });
    });
});

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
