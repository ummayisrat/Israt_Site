@extends('layouts.app')

@section('title', 'Messages | ISRAT.')

@section('content')

@include('journal._styles')

<style>
    .msg-row { display: flex; justify-content: space-between; gap: 20px; align-items: center; padding: 20px 25px; margin-bottom: 14px; background: rgba(255,250,242,.8); border: 1px solid rgba(210,198,180,.65); border-radius: 14px; }
    .msg-row.unread { border-left: 5px solid #b47752; }
    .msg-meta { color: #888; font-size: 14px; }
    .msg-preview { color: #555; margin-top: 4px; }
    .badge { background: #b47752; color: #fff; border-radius: 20px; padding: 2px 12px; font-size: 14px; letter-spacing: 0; vertical-align: middle; }
</style>

<section class="journal-page">

    <div class="journal-toolbar">
        <h1>Inbox
            @if ($unreadCount > 0)
                <span class="badge">{{ $unreadCount }} new</span>
            @endif
        </h1>
    </div>

    @if (session('message_success'))
        <div class="flash">{{ session('message_success') }}</div>
    @endif

    @forelse ($messages as $message)
        <div class="msg-row {{ $message->read_at ? '' : 'unread' }}">
            <div>
                <strong>{{ $message->name }}</strong>
                <span class="msg-meta">&lt;{{ $message->email }}&gt; &middot; {{ $message->created_at->format('M d, Y H:i') }}</span>
                <div class="msg-preview">{{ \Illuminate\Support\Str::limit($message->message, 100) }}</div>
            </div>
            <div class="actions">
                <a href="{{ route('messages.show', $message) }}" class="button">Open</a>
                <form method="POST" action="{{ route('messages.destroy', $message) }}"
                      onsubmit="return confirm('Delete this message?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button danger">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state"><p>No messages yet.</p></div>
    @endforelse

    @if ($messages->hasPages())
        <div class="pagination-wrap">
            @foreach ($messages->getUrlRange(1, $messages->lastPage()) as $page => $url)
                @if ($page == $messages->currentPage())
                    <span class="current">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        </div>
    @endif

</section>

@endsection
