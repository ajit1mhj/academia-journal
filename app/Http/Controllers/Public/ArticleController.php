<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function show(Article $article)
    {
        abort_if($article->status !== 'published', 404);

        $article->increment('views');
        $article->load('authors', 'files', 'issue.volume.journal');

        return view('public.article', compact('article'));
    }

    public function download(Article $article)
    {
        abort_if($article->status !== 'published', 404);

        // Get latest manuscript or revised file
        $manuscript = $article->files()
                               ->whereIn('file_type', ['manuscript', 'revised'])
                               ->latest('version')
                               ->first();

        // No file found
        if (!$manuscript) {
            return back()->withErrors(['error' => 'No file available for download.']);
        }

        // Check file physically exists
        if (!Storage::disk('private')->exists($manuscript->file_path)) {
            return back()->withErrors(['error' => 'File not found on server.']);
        }

        $article->increment('downloads');

       return response()->download(
    Storage::disk('private')->path($manuscript->file_path),
    $manuscript->original_name ?? 'manuscript.pdf'
        );
    }
}