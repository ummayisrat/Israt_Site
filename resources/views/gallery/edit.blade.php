@extends('layouts.app')

@section('title', 'Edit Photo | ISRAT.')

@section('content')

@include('journal._styles')

<section class="journal-page">
    <div class="journal-toolbar">
        <h1>Edit Photo</h1>
    </div>

    <form class="journal-form" method="POST" action="{{ route('gallery.update', $item) }}">
        @csrf
        @method('PUT')
        @include('gallery._form')

        <div class="actions">
            <button type="submit" class="button">Update Photo</button>
            <a href="{{ route('gallery.index') }}" class="button secondary">Cancel</a>
        </div>
    </form>
</section>

@endsection
