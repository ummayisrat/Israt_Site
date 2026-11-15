<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $name = trim($request->input('name', ''));
        $email = trim($request->input('email', ''));

        if ($name !== '' && $email !== '') {
            $request->session()->put([
                'registered_name' => $name,
                'registered_email' => $email,
                'registered' => true,
            ]);
        }

        return redirect()->route('welcome');
    }
}
