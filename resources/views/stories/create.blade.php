@extends('layouts.app')

@section('title', 'New Story | ISRAT.')

@section('content')

@include('journal._styles')

<section class="journal-page">
    <div class="journal-toolbar">
        <h1>New Story</h1>
    </div>

    <form class="journal-form" method="POST" action="{{ route('stories.store') }}">
        @csrf
        @include('stories._form')

        <div class="actions">
            <button type="submit" class="button">Save Story</button>
            <a href="{{ route('stories.index') }}" class="button secondary">Cancel</a>
        </div>
    </form>
</section>

@endsection
