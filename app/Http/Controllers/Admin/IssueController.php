<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IssueController extends Controller
{
    public function index()
    {
        $issues = Issue::with('volume.journal')->latest()->paginate(15);
        return view('admin.issues.index', compact('issues'));
    }

    public function create()
    {
        $volumes = Volume::with('journal')->get();
        return view('admin.issues.create', compact('volumes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'volume_id'        => 'required|exists:volumes,id',
            'issue_no'         => 'required|integer',
            'publication_date' => 'nullable|date',
            'cover_image'      => 'nullable|image|max:20480',
            'status'           => 'required|in:upcoming,draft,published,archived',
        ]);

        $data = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')
                                           ->store('covers', 'public');
        }

        Issue::create($data);

        return redirect()->route('admin.issues.index')
                         ->with('success', 'Issue created.');
    }

    public function edit(Issue $issue)
    {
        $volumes = Volume::with('journal')->get();
        return view('admin.issues.edit', compact('issue', 'volumes'));
    }

    public function update(Request $request, Issue $issue)
    {
        $data = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($issue->cover_image);
            $data['cover_image'] = $request->file('cover_image')
                                           ->store('covers', 'public');
        }

        $issue->update($data);

        return redirect()->route('admin.issues.index')
                         ->with('success', 'Issue updated.');
    }

    public function destroy(Issue $issue)
    {
        $issue->delete();
        return redirect()->route('admin.issues.index')
                         ->with('success', 'Issue deleted.');
    }
}