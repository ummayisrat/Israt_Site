@extends('layouts.app')

@section('title', 'Edit Entry | ISRAT.')

@section('content')

@include('journal._styles')

<section class="journal-page">
    <div class="journal-toolbar">
        <h1>Edit <span>entry</span></h1>
    </div>

    <form class="journal-form" method="POST" action="{{ route('journal.update', $entry) }}">
        @csrf
        @method('PUT')
        @include('journal._form')

        <div class="actions">
            <button type="submit" class="button">Update Entry</button>
            <a href="{{ route('journal.show', $entry) }}" class="button secondary">Cancel</a>
        </div>
    </form>
</section>

@endsection
