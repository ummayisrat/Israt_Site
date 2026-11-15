@extends('layouts.app')

@section('title', 'Stories | ISRAT.')

@section('content')

<style>

    .stories-page {

        max-width: 1100px;

        margin: auto;

        padding:
            70px 25px
            100px;
    }


    .story {

        position: relative;

        height: 600px;

        margin-bottom: 70px;

        border-radius: 20px;

        overflow: hidden;

        background: #222;

        box-shadow:
            0 25px 70px
            rgba(0,0,0,.12);
    }


    .story img {

        width: 100%;

        height: 100%;

        object-fit: cover;

        display: block;

        transition:
            transform 1s
            cubic-bezier(.2,.8,.2,1),

            filter .7s ease;
    }


    .story:hover img {

        transform:
            scale(1.07);

        filter:
            brightness(.72)
            saturate(1.08);
    }


    /* DARK CINEMATIC OVERLAY */

    .story::after {

        content: "";

        position: absolute;

        inset: 0;

        background:
            linear-gradient(
                to top,
                rgba(0,0,0,.82),
                rgba(0,0,0,.22) 55%,
                rgba(0,0,0,.05)
            );

        pointer-events: none;
    }


    /* STORY TEXT */

    .story-content {

        position: absolute;

        left: 50px;

        bottom: 45px;

        max-width: 650px;

        z-index: 2;

        color: white;
    }


    .story-number {

        color:
            rgba(255,255,255,.55);

        font-size: 13px;

        letter-spacing: 4px;

        margin-bottom: 15px;
    }


    .story-content h2 {

        font-size:
            clamp(38px,6vw,70px);

        font-weight: normal;

        line-height: 1;

        margin-bottom: 20px;
    }


    .story-content p {

        color:
            rgba(255,255,255,.78);

        font-size: 17px;

        line-height: 1.7;

        max-width: 560px;

        margin-bottom: 25px;
    }


    .story-button {

        display: inline-block;

        padding:
            10px 22px;

        border:
            1px solid
            rgba(255,255,255,.5);

        color: white;

        text-decoration: none;

        border-radius: 30px;

        transition: .3s;
    }


    .story-button:hover {

        background: white;

        color: #292621;

        transform:
            translateY(-2px);
    }


    /* SECOND STORY */

    .story.small {

        height: 480px;
    }


    /* MOBILE */

    @media(max-width:700px) {

        .story {

            height: 500px;

            margin-bottom: 40px;
        }

        .story.small {

            height: 430px;
        }

        .story-content {

            left: 25px;

            right: 25px;

            bottom: 30px;
        }

        .story-content h2 {

            font-size: 40px;
        }

        .story-content p {

            font-size: 15px;
        }
    }


    .story-actions { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
    .story-actions form { display: inline; }
    .story-actions button.story-button { background: transparent; font: inherit; cursor: pointer; }
    .story-actions button.story-button:hover { background: white; color: #222; }
</style>



<!-- =====================================================
     HERO
===================================================== -->

<section class="page-hero">

    <div class="circle circle-one"></div>

    <div class="circle circle-three"></div>


    <div class="page-hero-content">

        <p style="
            color:#b47752;
            letter-spacing:4px;
            text-transform:uppercase;
            font-size:12px;
            margin-bottom:20px;
        ">
            Fiction • Memories • Imagination
        </p>


        <h1>

            Little
            <span>Stories.</span>

        </h1>


        <p>

            Some stories are remembered.
            Others are imagined.

        </p>

    </div>

</section>



<!-- =====================================================
     STORIES
===================================================== -->

<section class="stories-page">

    @if (session('story_success'))
        <div style="max-width:1100px; margin:0 auto 30px; background:rgba(180,119,82,.12); border:1px solid rgba(180,119,82,.4); color:#8a5636; padding:14px 20px; border-radius:12px;">
            {{ session('story_success') }}
        </div>
    @endif

    <div style="margin-bottom:40px;">
        <a href="{{ route('stories.create') }}" class="button">+ New Story</a>
    </div>

    @foreach ($stories as $story)

    <article class="story {{ $loop->first ? '' : 'small' }} card">

        <img
            src="{{ $story->image_url }}"
            alt="{{ $story->image_alt ?? $story->title }}"
            loading="lazy"
        >

        <div class="story-content">

            <div class="story-number">
                STORY {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
            </div>

            <h2>{{ $story->title }}</h2>

            <p>{{ \Illuminate\Support\Str::limit($story->body, 160) }}</p>

            <div class="story-actions">
                <a href="{{ route('stories.show', $story) }}" class="story-button">Read Story</a>
                <a href="{{ route('stories.edit', $story) }}" class="story-button">Edit</a>
                <form method="POST" action="{{ route('stories.destroy', $story) }}"
                      onsubmit="return confirm('Delete this story?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="story-button">Delete</button>
                </form>
            </div>

        </div>

    </article>

    @endforeach

    @if ($stories->isEmpty())
        <p style="text-align:center; color:#777; padding:60px 0;">No stories yet.</p>
    @endif

</section>

@endsection