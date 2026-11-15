@extends('layouts.app')

@section('title', $story->title . ' | ISRAT.')

@section('content')

@include('journal._styles')

<section class="journal-page">

    @if (session('story_success'))
        <div class="flash">{{ session('story_success') }}</div>
    @endif

    <article class="journal-entry card no-image" style="transform:none;">
        <div class="journal-content">
            <div class="journal-date">Story</div>

            <h2>{{ $story->title }}</h2>

            <div class="journal-image" style="margin-bottom:30px;">
                <img src="{{ $story->image_url }}" alt="{{ $story->image_alt ?? $story->title }}">
            </div>

            <p>{{ $story->body }}</p>

            <div class="actions">
                <a href="{{ route('stories.index') }}" class="button secondary">&larr; Back</a>
                <a href="{{ route('stories.edit', $story) }}" class="button">Edit</a>
                <form method="POST" action="{{ route('stories.destroy', $story) }}"
                      onsubmit="return confirm('Delete this story?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button danger">Delete</button>
                </form>
            </div>
        </div>
    </article>

</section>

@endsection
