<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $items = GalleryItem::query()->oldest('id')->get();

        return view('gallery.index', compact('items'));
    }

    public function create(): View
    {
        return view('gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        GalleryItem::create($this->validatedData($request));

        return redirect()->route('gallery.index')->with('gallery_success', 'Photo added.');
    }

    public function edit(GalleryItem $item): View
    {
        return view('gallery.edit', compact('item'));
    }

    public function update(Request $request, GalleryItem $item): RedirectResponse
    {
        $item->update($this->validatedData($request));

        return redirect()->route('gallery.index')->with('gallery_success', 'Photo updated.');
    }

    public function destroy(GalleryItem $item): RedirectResponse
    {
        $item->delete();

        return redirect()->route('gallery.index')->with('gallery_success', 'Photo deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'image_url' => ['required', 'url', 'max:2048'],
            'image_alt' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
