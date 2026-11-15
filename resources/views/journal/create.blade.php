@extends('layouts.app')

@section('title', 'New Entry | ISRAT.')

@section('content')

@include('journal._styles')

<section class="journal-page">
    <div class="journal-toolbar">
        <h1>New <span>entry</span></h1>
    </div>

    <form class="journal-form" method="POST" action="{{ route('journal.store') }}">
        @csrf
        @include('journal._form')

        <div class="actions">
            <button type="submit" class="button">Save Entry</button>
            <a href="{{ route('journal.index') }}" class="button secondary">Cancel</a>
        </div>
    </form>
</section>

@endsection
