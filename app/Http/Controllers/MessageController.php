<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::query()->latest()->paginate(10);
        $unreadCount = ContactMessage::query()->whereNull('read_at')->count();

        return view('messages.index', compact('messages', 'unreadCount'));
    }

    public function show(ContactMessage $message): View
    {
        if ($message->read_at === null) {
            $message->update(['read_at' => now()]);
        }

        return view('messages.show', compact('message'));
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()
            ->route('messages.index')
            ->with('message_success', 'Message deleted.');
    }
}
