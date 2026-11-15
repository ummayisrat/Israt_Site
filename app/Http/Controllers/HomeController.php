<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(?string $name = null): View
    {
        $displayName = $name !== null && trim($name) !== ''
            ? ucwords(str_replace('-', ' ', trim($name)))
            : 'Israt';

        $comments = Comment::query()->latest()->limit(20)->get();

        return view('home', compact('displayName', 'comments'));
    }
}
