@extends('layouts.app')

@section('title', 'Welcome | ISRAT.')

@section('content')

<section class="page-hero">

    <div class="circle circle-one"></div>

    <div class="circle circle-two"></div>

    <div class="circle circle-three"></div>


    <div class="page-hero-content">

        <p style="
            letter-spacing:4px;
            text-transform:uppercase;
            font-size:12px;
            margin-bottom:20px;
            color:#b47752;
        ">
            A personal space
        </p>


        <h1>
            Welcome to
            <span>ISRAT.</span>
        </h1>


        <p>
            Thoughts, stories, journals and little
            fragments of life, collected in one place.
        </p>


        <div style="margin-top:35px;">

            <a
                href="{{ route('home') }}"
                class="button"
            >
                Enter the Journal
            </a>

        </div>

    </div>

</section>


<section class="container">

    <div class="card">

        <h2 class="section-title">
            A quiet place for thoughts.
        </h2>

        <p class="section-text">

            Welcome to ISRAT, a personal digital space
            where ideas, memories, stories and everyday
            observations find a place to breathe.

        </p>

    </div>

</section>

@endsection