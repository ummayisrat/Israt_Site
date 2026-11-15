<?php

use App\Models\GalleryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function galleryPayload(array $o = []): array
{
    return array_merge([
        'title' => 'Autumn',
        'category' => 'Nature',
        'image_url' => 'https://example.com/a.jpg',
        'image_alt' => 'A tree',
    ], $o);
}

test('gallery index lists photos', function () {
    GalleryItem::create(galleryPayload(['title' => 'Listed photo']));

    $this->get(route('gallery.index'))->assertOk()->assertSee('Listed photo');
});

test('a photo can be added', function () {
    $this->post(route('gallery.store'), galleryPayload())->assertRedirect(route('gallery.index'));

    $this->assertDatabaseHas('gallery_items', ['title' => 'Autumn']);
});

test('a photo requires title, category and valid image url', function () {
    $this->post(route('gallery.store'), galleryPayload(['title' => '', 'category' => '', 'image_url' => 'nope']))
        ->assertSessionHasErrors(['title', 'category', 'image_url']);
});

test('a photo can be updated and deleted', function () {
    $item = GalleryItem::create(galleryPayload());

    $this->put(route('gallery.update', $item), galleryPayload(['title' => 'Changed']))
        ->assertRedirect(route('gallery.index'));
    expect($item->fresh()->title)->toBe('Changed');

    $this->delete(route('gallery.destroy', $item))->assertRedirect(route('gallery.index'));
    $this->assertDatabaseMissing('gallery_items', ['id' => $item->id]);
});
