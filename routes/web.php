<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StoriesController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
*/

Route::get('/', [WelcomeController::class, 'index'])
    ->name('welcome');


/*
|--------------------------------------------------------------------------
| Home Page
|--------------------------------------------------------------------------
| The optional {name} value comes from the browser URL and is passed
| by the route to HomeController, which then passes it to the view.
| Example: /home/Ummay-Israt
|--------------------------------------------------------------------------
*/

Route::get('/home/{name?}', [HomeController::class, 'index'])
    ->name('home');


/*
|--------------------------------------------------------------------------
| Journal Page
|--------------------------------------------------------------------------
*/

Route::resource('journal', JournalController::class)
    ->parameters(['journal' => 'entry']);


/*
|--------------------------------------------------------------------------
| Stories Page
|--------------------------------------------------------------------------
*/

Route::resource('stories', StoriesController::class)
    ->parameters(['stories' => 'story']);


/*
|--------------------------------------------------------------------------
| Gallery Page
|--------------------------------------------------------------------------
*/

Route::resource('gallery', GalleryController::class)
    ->except('show')
    ->parameters(['gallery' => 'item']);


/*
|--------------------------------------------------------------------------
| Registration
|--------------------------------------------------------------------------
*/

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register');


/*
|--------------------------------------------------------------------------
| Comments
|--------------------------------------------------------------------------
*/

Route::post('/comment', [CommentController::class, 'store'])
    ->name('comment');


/*
|--------------------------------------------------------------------------
| Contact
|--------------------------------------------------------------------------
*/

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact');


/*
|--------------------------------------------------------------------------
| Contact Messages (private inbox)
|--------------------------------------------------------------------------
| Protected with HTTP Basic auth against the users table.
| Default seeded login: test@example.com / password
|--------------------------------------------------------------------------
*/

Route::middleware('auth.basic')
    ->prefix('messages')
    ->name('messages.')
    ->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/{message}', [MessageController::class, 'show'])->name('show');
        Route::delete('/{message}', [MessageController::class, 'destroy'])->name('destroy');
    });
