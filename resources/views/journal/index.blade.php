@extends('layouts.app')

@section('title', 'Journal | ISRAT.')

@section('content')

@include('journal._styles')

<section class="page-hero">
    <div class="circle circle-one"></div>
    <div class="circle circle-two"></div>
    <div class="circle circle-three"></div>

    <div class="page-hero-content">
        <p style="color:#b47752; letter-spacing:4px; text-transform:uppercase; font-size:12px; margin-bottom:20px;">
            Pages from my notebook
        </p>
        <h1>My <span>Journal.</span></h1>
        <p>Quiet thoughts, ordinary moments, and things worth remembering.</p>
    </div>
</section>

<section class="journal-page">

    <div class="journal-toolbar">
        <h1>All <span>entries</span></h1>
        <a href="{{ route('journal.create') }}" class="button">+ New Entry</a>
    </div>

    @if (session('journal_success'))
        <div class="flash">{{ session('journal_success') }}</div>
    @endif

    @forelse ($entries as $entry)
        <article class="journal-entry card {{ $entry->image_url ? '' : 'no-image' }}">

            @if ($entry->image_url)
                <div class="journal-image">
                    <img src="{{ $entry->image_url }}" alt="{{ $entry->title }}" loading="lazy">
                </div>
            @endif

            <div class="journal-content">
                <div class="journal-date">
                    {{ $entry->category }} &middot; {{ $entry->entry_date->format('M d, Y') }}
                </div>

                <h2>{{ $entry->title }}</h2>

                <p>{{ \Illuminate\Support\Str::limit($entry->body, 200) }}</p>

                <div class="actions">
                    <a href="{{ route('journal.show', $entry) }}" class="button">Read</a>
                    <a href="{{ route('journal.edit', $entry) }}" class="button secondary">Edit</a>
                    <form method="POST" action="{{ route('journal.destroy', $entry) }}"
                          onsubmit="return confirm('Delete this entry?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button danger">Delete</button>
                    </form>
                </div>
            </div>
        </article>
    @empty
        <div class="empty-state">
            <p>No journal entries yet.</p>
            <p style="margin-top:20px;"><a href="{{ route('journal.create') }}" class="button">Write the first one</a></p>
        </div>
    @endforelse

    @if ($entries->hasPages())
        <div class="pagination-wrap">
            @foreach ($entries->getUrlRange(1, $entries->lastPage()) as $page => $url)
                @if ($page == $entries->currentPage())
                    <span class="current">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        </div>
    @endif

</section>

@endsection
