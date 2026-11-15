<?php

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a comment is saved to the database', function () {
    $this->post(route('comment'), ['name' => 'Rafi', 'comment' => 'Nice site'])
        ->assertRedirect(route('home').'#comments')
        ->assertSessionHas('comment_success');

    $this->assertDatabaseHas('comments', ['name' => 'Rafi', 'comment' => 'Nice site']);
});

test('an invalid comment is rejected', function () {
    $this->post(route('comment'), ['name' => '', 'comment' => ''])
        ->assertSessionHasErrors(['name', 'comment'], errorBag: 'comment');

    expect(Comment::count())->toBe(0);
});

test('saved comments are shown on the home page', function () {
    Comment::create(['name' => 'Rafi', 'comment' => 'Visible comment']);

    $this->get(route('home'))->assertOk()->assertSee('Visible comment');
});
