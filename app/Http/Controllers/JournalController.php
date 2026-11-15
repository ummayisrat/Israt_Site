<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JournalController extends Controller
{
    /**
     * Read: list all entries (newest first).
     */
    public function index(): View
    {
        $entries = JournalEntry::query()
            ->latest('entry_date')
            ->latest('id')
            ->paginate(6);

        return view('journal.index', compact('entries'));
    }

    /**
     * Create: show the form.
     */
    public function create(): View
    {
        return view('journal.create');
    }

    /**
     * Create: save a new entry.
     */
    public function store(Request $request): RedirectResponse
    {
        JournalEntry::create($this->validatedData($request));

        return redirect()
            ->route('journal.index')
            ->with('journal_success', 'Journal entry created.');
    }

    /**
     * Read: show a single entry.
     */
    public function show(JournalEntry $entry): View
    {
        return view('journal.show', compact('entry'));
    }

    /**
     * Update: show the edit form.
     */
    public function edit(JournalEntry $entry): View
    {
        return view('journal.edit', compact('entry'));
    }

    /**
     * Update: save changes.
     */
    public function update(Request $request, JournalEntry $entry): RedirectResponse
    {
        $entry->update($this->validatedData($request));

        return redirect()
            ->route('journal.show', $entry)
            ->with('journal_success', 'Journal entry updated.');
    }

    /**
     * Delete: remove an entry.
     */
    public function destroy(JournalEntry $entry): RedirectResponse
    {
        $entry->delete();

        return redirect()
            ->route('journal.index')
            ->with('journal_success', 'Journal entry deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'body' => ['required', 'string'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'entry_date' => ['required', 'date'],
        ]);
    }
}
