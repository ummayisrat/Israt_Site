@extends('layouts.app')

@section('title', 'Gallery | ISRAT.')

@section('content')

<style>

    .gallery-page {

        max-width: 1200px;

        margin: auto;

        padding:
            70px 25px
            110px;
    }


    .gallery-intro {

        max-width: 650px;

        margin-bottom: 60px;
    }


    .gallery-intro h1 {

        font-size:
            clamp(55px,8vw,95px);

        font-weight: normal;

        line-height: .9;

        letter-spacing: -5px;

        margin-bottom: 25px;
    }


    .gallery-intro h1 span {

        color: #b47752;

        font-style: italic;
    }


    .gallery-intro p {

        color: #777;

        font-size: 18px;
    }


    /* =====================================================
       MASONRY GRID
    ===================================================== */

    .gallery-grid {

        columns: 3 280px;

        column-gap: 22px;
    }


    .gallery-item {

        break-inside: avoid;

        margin-bottom: 22px;

        position: relative;

        overflow: hidden;

        border-radius: 13px;

        cursor: pointer;

        background: #ddd;
    }


    .gallery-item img {

        width: 100%;

        height: auto;

        display: block;

        transition:
            transform .8s
            cubic-bezier(.2,.8,.2,1),

            filter .5s ease;
    }


    .gallery-item:hover img {

        transform:
            scale(1.08);

        filter:
            brightness(.82)
            saturate(1.12);
    }


    /* GLOW */

    .gallery-item::after {

        content: "";

        position: absolute;

        inset: 0;

        background:
            linear-gradient(
                135deg,
                rgba(255,255,255,.12),
                transparent 50%,
                rgba(180,119,82,.12)
            );

        opacity: 0;

        transition: .5s;

        pointer-events: none;
    }


    .gallery-item:hover::after {

        opacity: 1;
    }


    /* CAPTION */

    .gallery-caption {

        position: absolute;

        left: 20px;

        right: 20px;

        bottom: 18px;

        z-index: 3;

        color: white;

        opacity: 0;

        transform:
            translateY(10px);

        transition: .4s;

        text-shadow:
            0 2px 12px
            rgba(0,0,0,.4);
    }


    .gallery-item:hover
    .gallery-caption {

        opacity: 1;

        transform:
            translateY(0);
    }


    .gallery-caption h3 {

        font-size: 21px;

        font-weight: normal;

        margin-bottom: 3px;
    }


    .gallery-caption span {

        font-size: 12px;

        letter-spacing: 2px;

        text-transform: uppercase;

        opacity: .75;
    }


    /* =====================================================
       MOBILE
    ===================================================== */

    @media(max-width:700px) {

        .gallery-page {

            padding:
                50px 18px
                80px;
        }

        .gallery-grid {

            columns: 2 150px;

            column-gap: 12px;
        }

        .gallery-item {

            margin-bottom: 12px;
        }

        .gallery-caption {

            opacity: 1;

            transform: none;

            left: 12px;

            bottom: 12px;
        }

        .gallery-caption h3 {

            font-size: 15px;
        }

        .gallery-caption span {

            font-size: 9px;
        }
    }


    @media(max-width:420px) {

        .gallery-grid {

            columns: 1;
        }
    }


    .item-actions { display: flex; gap: 8px; margin-top: 10px; }
    .item-actions form { display: inline; }
    .item-actions a, .item-actions button { font: inherit; font-size: 12px; padding: 4px 12px; border-radius: 20px; border: 1px solid rgba(255,255,255,.7); background: rgba(0,0,0,.35); color: #fff; text-decoration: none; cursor: pointer; }
    .item-actions a:hover, .item-actions button:hover { background: #fff; color: #222; }
</style>



<!-- =====================================================
     HERO
===================================================== -->

<section class="page-hero">

    <div class="circle circle-two"></div>

    <div class="circle circle-three"></div>


    <div class="page-hero-content">

        <p style="
            color:#b47752;
            letter-spacing:4px;
            text-transform:uppercase;
            font-size:12px;
            margin-bottom:20px;
        ">
            Visual memories
        </p>


        <h1>

            The
            <span>Gallery.</span>

        </h1>


        <p>

            A collection of places,
            textures, light and little moments.

        </p>

    </div>

</section>



<!-- =====================================================
     GALLERY
===================================================== -->

<section class="gallery-page">


    <div class="gallery-intro">

        <h1>

            Moments
            <span>captured.</span>

        </h1>

        <p>

            Not everything needs a story.
            Sometimes a photograph is enough.

        </p>

    </div>



    @if (session('gallery_success'))
        <div style="margin-bottom:25px; background:rgba(180,119,82,.12); border:1px solid rgba(180,119,82,.4); color:#8a5636; padding:14px 20px; border-radius:12px;">
            {{ session('gallery_success') }}
        </div>
    @endif

    <div style="margin-bottom:35px;">
        <a href="{{ route('gallery.create') }}" class="button">+ Add Photo</a>
    </div>

    <div class="gallery-grid">

        @foreach ($items as $item)

        <div class="gallery-item">

            <img
                src="{{ $item->image_url }}"
                alt="{{ $item->image_alt ?? $item->title }}"
                loading="lazy"
            >

            <div class="gallery-caption">

                <h3>{{ $item->title }}</h3>

                <span>{{ $item->category }}</span>

                <div class="item-actions">
                    <a href="{{ route('gallery.edit', $item) }}">Edit</a>
                    <form method="POST" action="{{ route('gallery.destroy', $item) }}"
                          onsubmit="return confirm('Delete this photo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </div>

            </div>

        </div>

        @endforeach

        @if ($items->isEmpty())
            <p style="color:#777;">No photos yet.</p>
        @endif

    </div>

</section>

@endsection