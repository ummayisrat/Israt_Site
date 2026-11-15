<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoriesController extends Controller
{
    public function index(): View
    {
        $stories = Story::query()->oldest('id')->get();

        return view('stories.index', compact('stories'));
    }

    public function create(): View
    {
        return view('stories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Story::create($this->validatedData($request));

        return redirect()->route('stories.index')->with('story_success', 'Story created.');
    }

    public function show(Story $story): View
    {
        return view('stories.show', compact('story'));
    }

    public function edit(Story $story): View
    {
        return view('stories.edit', compact('story'));
    }

    public function update(Request $request, Story $story): RedirectResponse
    {
        $story->update($this->validatedData($request));

        return redirect()->route('stories.show', $story)->with('story_success', 'Story updated.');
    }

    public function destroy(Story $story): RedirectResponse
    {
        $story->delete();

        return redirect()->route('stories.index')->with('story_success', 'Story deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'image_url' => ['required', 'url', 'max:2048'],
            'image_alt' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
