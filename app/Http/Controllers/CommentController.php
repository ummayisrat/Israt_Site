<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('comment', [
            'name' => ['required', 'string', 'max:255'],
            'comment' => ['required', 'string', 'max:2000'],
        ]);

        // Saved in the database (comments table), not in the session.
        Comment::create($validated);

        return redirect()
            ->to(route('home').'#comments')
            ->with('comment_success', 'Your comment has been added.');
    }
}
