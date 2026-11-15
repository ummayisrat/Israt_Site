<?php

use App\Models\Story;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function storyPayload(array $o = []): array
{
    return array_merge([
        'title' => 'The City',
        'body' => 'The streets were loud.',
        'image_url' => 'https://example.com/a.jpg',
        'image_alt' => 'A street',
    ], $o);
}

test('stories index lists stories', function () {
    Story::create(storyPayload(['title' => 'Listed story']));

    $this->get(route('stories.index'))->assertOk()->assertSee('Listed story');
});

test('a story can be created', function () {
    $this->post(route('stories.store'), storyPayload())->assertRedirect(route('stories.index'));

    $this->assertDatabaseHas('stories', ['title' => 'The City']);
});

test('a story requires title, body and a valid image url', function () {
    $this->post(route('stories.store'), storyPayload(['title' => '', 'body' => '', 'image_url' => 'nope']))
        ->assertSessionHasErrors(['title', 'body', 'image_url']);
});

test('a story can be shown, updated and deleted', function () {
    $story = Story::create(storyPayload());

    $this->get(route('stories.show', $story))->assertOk()->assertSee('The City');

    $this->put(route('stories.update', $story), storyPayload(['title' => 'Changed']))
        ->assertRedirect(route('stories.show', $story));
    expect($story->fresh()->title)->toBe('Changed');

    $this->delete(route('stories.destroy', $story))->assertRedirect(route('stories.index'));
    $this->assertDatabaseMissing('stories', ['id' => $story->id]);
});
