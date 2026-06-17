<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Volume;
use App\Models\Journal;
use Illuminate\Http\Request;

class VolumeController extends Controller
{
    public function index()
    {
        $volumes = Volume::with('journal')->latest()->paginate(15);
        return view('admin.volumes.index', compact('volumes'));
    }

    public function create()
    {
        $journals = Journal::where('status', 'active')->get();
        return view('admin.volumes.create', compact('journals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'journal_id' => 'required|exists:journals,id',
            'volume_no'  => 'required|integer',
            'year'       => 'required|digits:4|integer',
        ]);

        Volume::create($request->all());

        return redirect()->route('admin.volumes.index')
                         ->with('success', 'Volume created.');
    }

    public function edit(Volume $volume)
    {
        $journals = Journal::where('status', 'active')->get();
        return view('admin.volumes.edit', compact('volume', 'journals'));
    }

    public function update(Request $request, Volume $volume)
    {
        $volume->update($request->all());
        return redirect()->route('admin.volumes.index')
                         ->with('success', 'Volume updated.');
    }

    public function destroy(Volume $volume)
    {
        $volume->delete();
        return redirect()->route('admin.volumes.index')
                         ->with('success', 'Volume deleted.');
    }
}