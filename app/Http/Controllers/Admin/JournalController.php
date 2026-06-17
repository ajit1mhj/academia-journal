<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class JournalController extends Controller
{
    public function index(): View
    {
        $journals = Journal::latest()->paginate(10);
        return view('admin.journals.index', compact('journals'));
    }

    public function create(): View
    {
        return view('admin.journals.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'                 => 'required|string|max:255',
            'issn'                  => 'nullable|string|max:20',
            'eissn'                 => 'nullable|string|max:20',
            'cover_image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'pdf_file'              => 'nullable|file|mimes:pdf|max:20480',
            'contact_email'         => 'nullable|email|max:255',
            'doi_prefix'            => 'nullable|string|max:100',
            'description'           => 'nullable|string',
            'aim_scope'             => 'nullable|string',
            'subject_areas'         => 'nullable|string',
            'language'              => 'nullable|string|max:100',
            'publication_frequency' => 'nullable|string',
        ]);

        $data = $request->except(['cover_image', 'pdf_file']);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')
                ->store('journals', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $request->file('pdf_file')
                ->store('journals/pdfs', 'public');
        }

        Journal::create($data);

        return redirect()->route('admin.journals.index')
            ->with('success', 'Journal created successfully.');
    }

    public function edit(Journal $journal): View
    {
        return view('admin.journals.edit', compact('journal'));
    }

    public function update(Request $request, Journal $journal): RedirectResponse
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'cover_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'pdf_file'     => 'nullable|file|mimes:pdf|max:20480',
            'contact_email' => 'nullable|email|max:255',
        ]);

        $data = $request->except(['cover_image', 'pdf_file', '_token', '_method']);

        if ($request->hasFile('cover_image')) {
            if ($journal->cover_image) {
                Storage::disk('public')->delete($journal->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')
                ->store('journals', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            if ($journal->pdf_file) {
                Storage::disk('public')->delete($journal->pdf_file);
            }
            $data['pdf_file'] = $request->file('pdf_file')
                ->store('journals/pdfs', 'public');
        }

        $journal->update($data);

        return redirect()->route('admin.journals.index')
            ->with('success', 'Journal updated successfully.');
    }

    public function destroy(Journal $journal): RedirectResponse
    {
        if ($journal->cover_image) {
            Storage::disk('public')->delete($journal->cover_image);
        }
        if ($journal->pdf_file) {
            Storage::disk('public')->delete($journal->pdf_file);
        }

        $journal->delete();

        return redirect()->route('admin.journals.index')
            ->with('success', 'Journal deleted.');
    }
}
