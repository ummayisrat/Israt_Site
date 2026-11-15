<?php

use App\Models\JournalEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function journalPayload(array $overrides = []): array
{
    return array_merge([
        'title' => 'My day',
        'category' => 'Journal Entry',
        'body' => 'Something worth remembering.',
        'image_url' => null,
        'entry_date' => '2026-11-04',
    ], $overrides);
}

test('index lists entries', function () {
    JournalEntry::create(journalPayload(['title' => 'Listed entry']));

    $this->get(route('journal.index'))
        ->assertOk()
        ->assertSee('Listed entry');
});

test('an entry can be created', function () {
    $this->post(route('journal.store'), journalPayload())
        ->assertRedirect(route('journal.index'));

    $this->assertDatabaseHas('journal_entries', ['title' => 'My day']);
});

test('creating requires a title and body', function () {
    $this->post(route('journal.store'), journalPayload(['title' => '', 'body' => '']))
        ->assertSessionHasErrors(['title', 'body']);
});

test('an entry can be shown', function () {
    $entry = JournalEntry::create(journalPayload());

    $this->get(route('journal.show', $entry))->assertOk()->assertSee('My day');
});

test('an entry can be updated', function () {
    $entry = JournalEntry::create(journalPayload());

    $this->put(route('journal.update', $entry), journalPayload(['title' => 'Changed']))
        ->assertRedirect(route('journal.show', $entry));

    expect($entry->fresh()->title)->toBe('Changed');
});

test('an entry can be deleted', function () {
    $entry = JournalEntry::create(journalPayload());

    $this->delete(route('journal.destroy', $entry))
        ->assertRedirect(route('journal.index'));

    $this->assertDatabaseMissing('journal_entries', ['id' => $entry->id]);
});
