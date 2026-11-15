@extends('layouts.app')

@section('title', 'Edit Story | ISRAT.')

@section('content')

@include('journal._styles')

<section class="journal-page">
    <div class="journal-toolbar">
        <h1>Edit Story</h1>
    </div>

    <form class="journal-form" method="POST" action="{{ route('stories.update', $story) }}">
        @csrf
        @method('PUT')
        @include('stories._form')

        <div class="actions">
            <button type="submit" class="button">Update Story</button>
            <a href="{{ route('stories.show', $story) }}" class="button secondary">Cancel</a>
        </div>
    </form>
</section>

@endsection
