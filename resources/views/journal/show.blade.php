@extends('layouts.app')

@section('title', $entry->title . ' | ISRAT.')

@section('content')

@include('journal._styles')

<section class="journal-page">

    @if (session('journal_success'))
        <div class="flash">{{ session('journal_success') }}</div>
    @endif

    <article class="journal-entry card no-image" style="transform:none;">
        <div class="journal-content">
            <div class="journal-date">
                {{ $entry->category }} &middot; {{ $entry->entry_date->format('F d, Y') }}
            </div>

            <h2>{{ $entry->title }}</h2>

            @if ($entry->image_url)
                <div class="journal-image" style="margin-bottom:30px;">
                    <img src="{{ $entry->image_url }}" alt="{{ $entry->title }}">
                </div>
            @endif

            <p>{{ $entry->body }}</p>

            <div class="actions">
                <a href="{{ route('journal.index') }}" class="button secondary">&larr; Back</a>
                <a href="{{ route('journal.edit', $entry) }}" class="button">Edit</a>
                <form method="POST" action="{{ route('journal.destroy', $entry) }}"
                      onsubmit="return confirm('Delete this entry?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button danger">Delete</button>
                </form>
            </div>
        </div>
    </article>

</section>

@endsection
