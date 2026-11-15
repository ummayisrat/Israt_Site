@extends('layouts.app')

@section('title', 'Message | ISRAT.')

@section('content')

@include('journal._styles')

<section class="journal-page">

    <article class="journal-entry card no-image" style="transform:none;">
        <div class="journal-content">
            <div class="journal-date">
                {{ $message->created_at->format('F d, Y H:i') }}
            </div>

            <h2>{{ $message->name }}</h2>

            <p style="margin-bottom:10px;">
                <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
            </p>

            <p>{{ $message->message }}</p>

            <div class="actions">
                <a href="{{ route('messages.index') }}" class="button secondary">&larr; Back</a>
                <a href="mailto:{{ $message->email }}" class="button">Reply by email</a>
                <form method="POST" action="{{ route('messages.destroy', $message) }}"
                      onsubmit="return confirm('Delete this message?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button danger">Delete</button>
                </form>
            </div>
        </div>
    </article>

</section>

@endsection
