<?php

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a contact message is saved to the database', function () {
    $this->post(route('contact'), [
        'name' => 'Rafi',
        'email' => 'rafi@example.com',
        'message' => 'Hello there!',
    ])->assertRedirect(route('home').'#contact')
        ->assertSessionHas('contact_success');

    $this->assertDatabaseHas('contact_messages', ['email' => 'rafi@example.com']);
});

test('an invalid contact message is rejected', function () {
    $this->post(route('contact'), ['name' => '', 'email' => 'nope', 'message' => ''])
        ->assertSessionHasErrors(['name', 'email', 'message'], errorBag: 'contact');

    expect(ContactMessage::count())->toBe(0);
});

test('the inbox requires login', function () {
    $this->get(route('messages.index'))->assertUnauthorized();
});

test('a logged in user can read and delete messages', function () {
    $message = ContactMessage::create(['name' => 'Rafi', 'email' => 'rafi@example.com', 'message' => 'Hi']);
    $this->actingAs(User::factory()->create());

    $this->get(route('messages.index'))->assertOk()->assertSee('Rafi');

    $this->get(route('messages.show', $message))->assertOk()->assertSee('Hi');
    expect($message->fresh()->read_at)->not->toBeNull();

    $this->delete(route('messages.destroy', $message))->assertRedirect(route('messages.index'));
    $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
});
