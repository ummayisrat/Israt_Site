@extends('layouts.app')

@section('title', 'Home | ISRAT.')

@section('content')


<!-- =====================================================
     HERO
===================================================== -->

<section class="page-hero">

    <div class="circle circle-one"></div>

    <div class="circle circle-two"></div>

    <div class="circle circle-three"></div>


    <div class="page-hero-content">

        <p style="
            color:#b47752;
            letter-spacing:4px;
            text-transform:uppercase;
            font-size:12px;
        ">
            Welcome to my world
        </p>


        <h1>

            Hello,
            <span>I'm {{ $displayName }}.</span>

        </h1>


        <p>

            A collection of thoughts,
            stories and moments that
            matter.

        </p>

    </div>

</section>



<!-- =====================================================
     ABOUT
===================================================== -->

<section class="container">

    <div class="card">

        <h2 class="section-title">
            About
        </h2>


        <p class="section-text">

            This is my little corner of the internet.

            <br><br>

            Here I write about things I notice,
            ideas I explore, stories I remember,
            and moments that deserve to stay.

        </p>

    </div>

</section>



<!-- =====================================================
     COMMENTS
===================================================== -->

<section class="container" id="comments">

    <h2 class="section-title">
        Leave a thought.
    </h2>


    <div class="card">

        @if(session('comment_success'))

            <p style="
                color:#6b8e63;
                margin-bottom:20px;
            ">
                {{ session('comment_success') }}
            </p>

        @endif

        @if($errors->comment->any())

            <p style="color:#a43d3d; margin-bottom:20px;">
                {{ $errors->comment->first() }}
            </p>

        @endif


        <form
            method="POST"
            action="{{ route('comment') }}"
            class="form"
        >

            @csrf


            <input
                type="text"
                name="name"
                placeholder="Your name"
                value="{{ $errors->hasBag('comment') ? old('name') : '' }}"
                required
            >


            <textarea
                name="comment"
                placeholder="Write something..."
                required
            >{{ $errors->hasBag('comment') ? old('comment') : '' }}</textarea>


            <button
                type="submit"
                class="button"
            >
                Leave Comment
            </button>

        </form>


        @foreach($comments as $comment)

            <div style="
                margin-top:25px;
                padding-top:20px;
                border-top:1px solid rgba(210,198,180,.65);
            ">
                <strong>{{ $comment->name }}</strong>
                <span style="color:#999; font-size:14px;">
                    &middot; {{ $comment->created_at->format('M d, Y') }}
                </span>
                <p style="color:#555; white-space:pre-line;">{{ $comment->comment }}</p>
            </div>

        @endforeach

    </div>

</section>



<!-- =====================================================
     CONTACT
     
     IMPORTANT:
     id="contact" is required because Navbar
     Contact link points to /home#contact
===================================================== -->

<section
    class="container"
    id="contact"
>

    <div class="card">

        <h2 class="section-title">
            Contact
        </h2>


        <p class="section-text">

            Have something to say?

            <br>

            I'd love to hear from you.

        </p>


        <br>


        @if(session('contact_success'))

            <p style="
                color:#6b8e63;
                margin-bottom:20px;
            ">
                {{ session('contact_success') }}
            </p>

        @endif

        @if($errors->contact->any())

            <p style="
                color:#a43d3d;
                margin-bottom:20px;
            ">
                {{ $errors->contact->first() }}
            </p>

        @endif


        <form
            method="POST"
            action="{{ route('contact') }}"
            class="form"
        >

            @csrf


            <input
                type="text"
                name="name"
                placeholder="Your name"
                value="{{ $errors->hasBag('contact') ? old('name') : '' }}"
                required
            >


            <input
                type="email"
                name="email"
                placeholder="Your email"
                value="{{ $errors->hasBag('contact') ? old('email') : '' }}"
                required
            >


            <textarea
                name="message"
                placeholder="Your message..."
                required
            >{{ $errors->hasBag('contact') ? old('message') : '' }}</textarea>


            <button
                type="submit"
                class="button"
            >
                Send Message
            </button>

        </form>

    </div>

</section>


@endsection