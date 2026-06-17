<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EditorialBoard;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorialBoardController extends Controller
{
    public function index()
    {
        $members = EditorialBoard::with('journal')
                                 ->orderBy('category')
                                 ->orderBy('order')
                                 ->paginate(15);

        return view('admin.editorial-board.index', compact('members'));
    }

    public function create()
    {
        $journals   = Journal::where('status', 'active')->get();
        $categories = $this->getCategories();

        return view('admin.editorial-board.create', compact('journals', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'journal_id'  => 'required|exists:journals,id',
            'name'        => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'country'     => 'nullable|string|max:100',
            'biography'   => 'nullable|string',
            'category'    => 'required|in:editor_in_chief,managing_editor,editorial_board,review_board,advisory_board',
            'order'       => 'nullable|integer|min:0',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('photo');
        $data['order'] = $request->order ?? 0;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('editorial', 'public');
        }

        EditorialBoard::create($data);

        return redirect()->route('admin.editorial-board.index')
                         ->with('success', 'Editorial board member added successfully.');
    }

    public function show(EditorialBoard $editorialBoard)
    {
        $editorialBoard->load('journal');
        return view('admin.editorial-board.show', compact('editorialBoard'));
    }

    public function edit(EditorialBoard $editorialBoard)
    {
        $journals   = Journal::where('status', 'active')->get();
        $categories = $this->getCategories();

        return view('admin.editorial-board.edit', compact('editorialBoard', 'journals', 'categories'));
    }

    public function update(Request $request, EditorialBoard $editorialBoard)
    {
        $request->validate([
            'journal_id'  => 'required|exists:journals,id',
            'name'        => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'country'     => 'nullable|string|max:100',
            'biography'   => 'nullable|string',
            'category'    => 'required|in:editor_in_chief,managing_editor,editorial_board,review_board,advisory_board',
            'order'       => 'nullable|integer|min:0',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except(['photo', '_token', '_method']);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($editorialBoard->photo) {
                Storage::disk('public')->delete($editorialBoard->photo);
            }
            $data['photo'] = $request->file('photo')->store('editorial', 'public');
        }

        $editorialBoard->update($data);

        return redirect()->route('admin.editorial-board.index')
                         ->with('success', 'Member updated successfully.');
    }

    public function destroy(EditorialBoard $editorialBoard)
    {
        if ($editorialBoard->photo) {
            Storage::disk('public')->delete($editorialBoard->photo);
        }

        $editorialBoard->delete();

        return redirect()->route('admin.editorial-board.index')
                         ->with('success', 'Member removed successfully.');
    }

    // Reorder members via drag-and-drop (called via AJAX)
    public function reorder(Request $request)
    {
        $request->validate([
            'orders'          => 'required|array',
            'orders.*.id'     => 'required|exists:editorial_boards,id',
            'orders.*.order'  => 'required|integer|min:0',
        ]);

        foreach ($request->orders as $item) {
            EditorialBoard::where('id', $item['id'])
                          ->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    // Filter by category (called via AJAX or query param)
    public function byCategory(Request $request)
    {
        $category = $request->category;
        $journals  = Journal::where('status', 'active')->get();

        $query = EditorialBoard::with('journal')->orderBy('order');

        if ($category) {
            $query->where('category', $category);
        }

        $members    = $query->paginate(15);
        $categories = $this->getCategories();

        return view('admin.editorial-board.index', compact('members', 'journals', 'categories', 'category'));
    }

    private function getCategories(): array
    {
        return [
            'editor_in_chief'  => 'Editor in Chief',
            'managing_editor'  => 'Managing Editor',
            'editorial_board'  => 'Editorial Board',
            'review_board'     => 'Review Board',
            'advisory_board'   => 'Advisory Board',
        ];
    }
}