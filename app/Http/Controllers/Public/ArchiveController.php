<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Volume;
use App\Models\Article;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $volumes = Volume::with('issues.articles')   // make sure no '.authors' chained
            ->where('status', 'active')
            ->orderByDesc('year')
            ->get();

        $query = Article::where('status', 'published')
            ->with('issue.volume');   // remove 'authors' if present

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('abstract', 'like', '%' . $request->keyword . '%')
                    ->orWhere('keywords', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('author')) {
            $query->whereHas(
                'authors',
                fn($q) =>
                $q->where('name', 'like', '%' . $request->author . '%')
            );
        }

        if ($request->filled('doi')) {
            $query->where('doi', $request->doi);
        }

        if ($request->filled('volume')) {
            $query->whereHas(
                'issue.volume',
                fn($q) =>
                $q->where('id', $request->volume)
            );
        }

        $articles = $query->latest('published_at')->paginate(15);

        return view('public.archives', compact('volumes', 'articles'));
    }
}
