@extends('layouts.app')

@section('title', 'Add Photo | ISRAT.')

@section('content')

@include('journal._styles')

<section class="journal-page">
    <div class="journal-toolbar">
        <h1>Add Photo</h1>
    </div>

    <form class="journal-form" method="POST" action="{{ route('gallery.store') }}">
        @csrf
        @include('gallery._form')

        <div class="actions">
            <button type="submit" class="button">Save Photo</button>
            <a href="{{ route('gallery.index') }}" class="button secondary">Cancel</a>
        </div>
    </form>
</section>

@endsection
