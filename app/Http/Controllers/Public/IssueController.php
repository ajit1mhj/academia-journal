<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\Journal;
use App\Models\Volume;

class IssueController extends Controller
{
    public function current()
    {
        $issue = Issue::where('status', 'published')
            ->with([
                'volume.journal',
                'articles.files',
            ])
            ->latest('publication_date')
            ->first();

        $volumes = Volume::with('issues', 'journal')
            ->orderByDesc('year')
            ->orderByDesc('volume_no')
            ->get();

        $journal = $issue?->volume?->journal ?? Journal::first();

        return view('public.current-issue', compact('issue', 'volumes', 'journal'));
    }

    public function show(int $volumeNo, int $issueNo)
    {
        $volume = Volume::where('volume_no', $volumeNo)
            ->with('journal')
            ->firstOrFail();

        $issue = Issue::where('volume_id', $volume->id)
            ->where('issue_no', $issueNo)
            ->with([
                'volume.journal',
                'articles.files',   // ← no 'authors' here either
            ])
            ->firstOrFail();

        $volumes = Volume::with('issues', 'journal')
            ->orderByDesc('year')
            ->orderByDesc('volume_no')
            ->get();

        $journal = $issue->volume->journal;

        return view('public.issue', compact('issue', 'volumes', 'journal'));
    }
}
