<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'ISRAT.')
    </title>

    <style>

        /* =====================================================
           RESET
        ===================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            background: #f5efe5;

            color: #292621;

            line-height: 1.7;

            overflow-x: hidden;

            transition:
                background .4s ease,
                color .4s ease;
        }


        /* =====================================================
           AMBIENT BACKGROUND GLOW
        ===================================================== */

        .ambient-glow {

            position: fixed;

            width: 420px;
            height: 420px;

            border-radius: 50%;

            pointer-events: none;

            z-index: -2;

            filter: blur(80px);

            opacity: .16;

            animation:
                ambientFloat
                12s ease-in-out infinite;
        }

        .glow-one {

            background:
                radial-gradient(
                    circle,
                    #d99ab7,
                    transparent 70%
                );

            top: -150px;
            left: -120px;
        }

        .glow-two {

            background:
                radial-gradient(
                    circle,
                    #8ebdca,
                    transparent 70%
                );

            right: -160px;
            top: 35%;

            animation-delay: 3s;
        }

        .glow-three {

            background:
                radial-gradient(
                    circle,
                    #d8b56e,
                    transparent 70%
                );

            bottom: -180px;
            left: 35%;

            animation-delay: 6s;
        }

        @keyframes ambientFloat {

            0%, 100% {

                transform:
                    translate3d(0,0,0)
                    scale(1);
            }

            50% {

                transform:
                    translate3d(35px,-25px,0)
                    scale(1.12);
            }
        }


        /* =====================================================
           CURSOR GLOW
        ===================================================== */

        .cursor-glow {

            position: fixed;

            width: 230px;
            height: 230px;

            border-radius: 50%;

            pointer-events: none;

            z-index: 9998;

            transform:
                translate(-50%,-50%);

            background:
                radial-gradient(
                    circle,
                    rgba(191,129,91,.18),
                    rgba(191,129,91,.08) 30%,
                    transparent 72%
                );

            filter: blur(2px);
        }


        .cursor-dot {

            position: fixed;

            width: 8px;
            height: 8px;

            border-radius: 50%;

            pointer-events: none;

            z-index: 10001;

            transform:
                translate(-50%,-50%);

            background: #b47752;

            box-shadow:
                0 0 10px rgba(180,119,82,.8),
                0 0 25px rgba(180,119,82,.35);
        }


        /* =====================================================
           MOUSE TRAIL
        ===================================================== */

        .glow-trail {

            position: fixed;

            width: 12px;
            height: 12px;

            border-radius: 50%;

            pointer-events: none;

            z-index: 9997;

            transform:
                translate(-50%,-50%);

            background:
                radial-gradient(
                    circle,
                    rgba(180,119,82,.5),
                    transparent 70%
                );

            animation:
                trailFade
                .7s ease-out forwards;
        }

        @keyframes trailFade {

            0% {

                opacity: .75;

                transform:
                    translate(-50%,-50%)
                    scale(.5);
            }

            100% {

                opacity: 0;

                transform:
                    translate(-50%,-50%)
                    scale(2.8);
            }
        }


        /* =====================================================
           TOUCH / CLICK RIPPLE
        ===================================================== */

        .touch-ripple {

            position: fixed;

            width: 20px;
            height: 20px;

            border-radius: 50%;

            pointer-events: none;

            z-index: 10000;

            transform:
                translate(-50%,-50%);

            border:
                2px solid
                rgba(180,119,82,.7);

            box-shadow:
                0 0 12px rgba(180,119,82,.35),
                inset 0 0 12px rgba(180,119,82,.15);

            animation:
                rippleExpand
                .8s
                cubic-bezier(.16,1,.3,1)
                forwards;
        }

        @keyframes rippleExpand {

            0% {

                width: 20px;
                height: 20px;

                opacity: .9;
            }

            100% {

                width: 180px;
                height: 180px;

                opacity: 0;
            }
        }


        /* =====================================================
           TOUCH PARTICLES
        ===================================================== */

        .touch-particle {

            position: fixed;

            width: 6px;
            height: 6px;

            border-radius: 50%;

            pointer-events: none;

            z-index: 10001;

            background:
                rgba(180,119,82,.55);

            box-shadow:
                0 0 10px
                rgba(180,119,82,.4);

            animation:
                particleBurst
                .7s ease-out forwards;
        }

        @keyframes particleBurst {

            0% {

                opacity: .8;

                transform:
                    translate(-50%,-50%)
                    scale(1);
            }

            100% {

                opacity: 0;

                transform:
                    translate(
                        calc(-50% + var(--move-x)),
                        calc(-50% + var(--move-y))
                    )
                    scale(.1);
            }
        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        nav {

            height: 72px;

            padding:
                0 8%;

            display: flex;

            align-items: center;

            justify-content: space-between;

            position: sticky;

            top: 0;

            z-index: 100;

            background:
                rgba(245,239,229,.88);

            backdrop-filter:
                blur(15px);

            border-bottom:
                1px solid #ddd4c5;
        }


        /* =====================================================
           ISRAT LOGO
        ===================================================== */

        .logo {

            color: #292621;

            text-decoration: none;

            font-size: 27px;

            font-weight: bold;

            letter-spacing: 4px;

            transition: .3s;
        }

        .logo span {

            color: #b47752;
        }

        .logo:hover {

            color: #b47752;

            letter-spacing: 7px;

            text-shadow:
                0 0 15px
                rgba(180,119,82,.3);
        }


        /* =====================================================
           NAV LINKS
        ===================================================== */

        .nav-links {

            display: flex;

            align-items: center;

            gap: 25px;
        }

        .nav-links a {

            position: relative;

            text-decoration: none;

            color: #555;

            font-size: 15px;

            padding: 8px 3px;

            transition:
                color .25s ease,
                transform .25s ease;
        }

        .nav-links a:hover {

            color: #b47752;

            transform:
                translateY(-2px);

            text-shadow:
                0 0 12px
                rgba(180,119,82,.25);
        }

        .nav-links a::after {

            content: "";

            position: absolute;

            left: 0;
            bottom: -5px;

            width: 0;
            height: 1px;

            background: #b47752;

            transition: .3s;
        }

        .nav-links a:hover::after {

            width: 100%;
        }


        /* =====================================================
           THEME BUTTON
        ===================================================== */

        .theme-button {

            width: 40px;
            height: 40px;

            border: none;

            border-radius: 50%;

            background: #292621;

            color: white;

            cursor: pointer;

            transition: .3s;
        }

        .theme-button:hover {

            transform:
                rotate(20deg)
                scale(1.1);

            box-shadow:
                0 0 20px
                rgba(180,119,82,.3);
        }


        /* =====================================================
           HERO
        ===================================================== */

        .page-hero {

            min-height: 65vh;

            display: flex;

            justify-content: center;

            align-items: center;

            text-align: center;

            padding:
                80px 20px;

            position: relative;

            overflow: hidden;
        }

        .page-hero-content {

            position: relative;

            z-index: 2;

            animation:
                appear
                1s ease;
        }

        .page-hero h1 {

            font-size:
                clamp(55px,9vw,100px);

            line-height: .9;

            font-weight: normal;

            letter-spacing: -5px;

            margin-bottom: 25px;
        }

        .page-hero h1 span {

            color: #b47752;

            font-style: italic;
        }

        .page-hero p {

            max-width: 600px;

            margin: auto;

            color: #777;

            font-size: 18px;
        }

        @keyframes appear {

            from {

                opacity: 0;

                transform:
                    translateY(35px);
            }

            to {

                opacity: 1;

                transform:
                    translateY(0);
            }
        }


        /* =====================================================
           ART CIRCLES
        ===================================================== */

        .circle {

            position: absolute;

            border-radius: 50%;

            opacity: .4;

            pointer-events: none;

            animation:
                floating
                6s ease-in-out infinite;
        }

        .circle-one {

            width: 220px;
            height: 220px;

            background: #d9b5c7;

            left: 5%;
            top: 10%;
        }

        .circle-two {

            width: 160px;
            height: 160px;

            background: #abc7d1;

            right: 7%;
            bottom: 10%;

            animation-delay: 1s;
        }

        .circle-three {

            width: 80px;
            height: 80px;

            background: #dfc27d;

            right: 25%;
            top: 15%;

            animation-delay: 2s;
        }

        @keyframes floating {

            0%,100% {

                transform:
                    translateY(0)
                    rotate(0);
            }

            50% {

                transform:
                    translateY(-25px)
                    rotate(8deg);
            }
        }


        /* =====================================================
           CONTAINER
        ===================================================== */

        .container {

            max-width: 900px;

            margin: auto;

            padding:
                80px 20px;
        }

        .section-title {

            font-size: 42px;

            font-weight: normal;

            margin-bottom: 35px;
        }

        .section-text {

            color: #666;

            font-size: 17px;

            line-height: 1.9;
        }


        /* =====================================================
           CARDS
        ===================================================== */

        .card {

            position: relative;

            overflow: hidden;

            background:
                rgba(255,250,242,.82);

            border:
                1px solid
                rgba(210,198,180,.7);

            border-radius: 12px;

            padding: 35px;

            margin-bottom: 25px;

            transition:
                transform .35s ease,
                box-shadow .35s ease,
                border-color .35s ease;

            opacity: 0;

            transform:
                translateY(30px);

            transform-style:
                preserve-3d;
        }

        .card::before {

            content: "";

            position: absolute;

            width: 250px;
            height: 250px;

            border-radius: 50%;

            pointer-events: none;

            left:
                var(--mouse-x,-200px);

            top:
                var(--mouse-y,-200px);

            transform:
                translate(-50%,-50%);

            background:
                radial-gradient(
                    circle,
                    rgba(180,119,82,.13),
                    transparent 70%
                );

            filter: blur(10px);
        }

        .card:hover {

            transform:
                translateY(-8px)
                scale(1.01);

            box-shadow:
                0 25px 60px
                rgba(0,0,0,.10),

                0 0 30px
                rgba(180,119,82,.06);
        }

        .card.show {

            opacity: 1;

            transform:
                translateY(0);
        }


        /* =====================================================
           BUTTON
        ===================================================== */

        .button {

            display: inline-block;

            padding:
                11px 22px;

            border-radius: 30px;

            border: none;

            background: #292621;

            color: white;

            text-decoration: none;

            cursor: pointer;

            transition: .3s;
        }

        .button:hover {

            background: #b47752;

            transform:
                translateY(-2px);

            box-shadow:
                0 8px 25px
                rgba(180,119,82,.25);
        }


        /* =====================================================
           FORM
        ===================================================== */

        .form {

            display: flex;

            flex-direction: column;

            gap: 13px;
        }

        .form input,
        .form textarea {

            width: 100%;

            padding: 14px;

            background:
                rgba(255,250,242,.8);

            border:
                1px solid #d9cfc0;

            border-radius: 5px;

            outline: none;

            transition: .3s;
        }

        .form textarea {

            min-height: 130px;

            resize: vertical;
        }

        .form input:focus,
        .form textarea:focus {

            border-color:
                #b47752;

            box-shadow:
                0 0 0 3px
                rgba(180,119,82,.1),

                0 0 20px
                rgba(180,119,82,.08);
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        footer {

            padding: 35px;

            text-align: center;

            color: #888;

            border-top:
                1px solid #ddd4c5;
        }


        /* =====================================================
           DARK MODE
        ===================================================== */

        body.dark {

            background: #181716;

            color: #eee;
        }

        body.dark nav {

            background:
                rgba(24,23,22,.9);

            border-color: #333;
        }

        body.dark .logo {

            color: #eee;
        }

        body.dark .nav-links a {

            color: #aaa;
        }

        body.dark .card {

            background:
                rgba(36,35,33,.9);

            border-color: #3a3835;
        }

        body.dark .section-text {

            color: #bbb;
        }

        body.dark .page-hero p {

            color: #aaa;
        }

        body.dark .form input,
        body.dark .form textarea {

            background: #242321;

            border-color: #444;

            color: white;
        }

        body.dark footer {

            border-color: #333;
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media(max-width:800px) {

            nav {

                padding:
                    0 5%;
            }

            .nav-links {

                gap: 12px;
            }

            .nav-links a {

                font-size: 13px;
            }
        }


        @media(max-width:650px) {

            nav {

                height: 65px;
            }

            .nav-links {

                display: none;
            }

            .page-hero h1 {

                font-size: 55px;

                letter-spacing: -3px;
            }

            .card {

                padding: 25px;
            }

            .cursor-glow,
            .cursor-dot {

                display: none;
            }
        }

    </style>

</head>


<!-- =========================================================
     BODY
========================================================= -->

<body>


    <!-- =====================================================
         GLOW TEXTURE
         
         THIS IS THE PART YOU ASKED ABOUT
    ====================================================== -->

    <div class="ambient-glow glow-one"></div>

    <div class="ambient-glow glow-two"></div>

    <div class="ambient-glow glow-three"></div>


    <!-- =====================================================
         MOUSE GLOW
    ====================================================== -->

    <div
        class="cursor-glow"
        id="cursorGlow"
    ></div>


    <div
        class="cursor-dot"
        id="cursorDot"
    ></div>



    <!-- =====================================================
         NAVIGATION
    ====================================================== -->

    <nav>

        <a
            href="/"
            class="logo"
        >
            ISRAT<span>.</span>
        </a>


        <div class="nav-links">

            <a href="/home">
                Home
            </a>

            <a href="/journal">
                Journal
            </a>

            <a href="/stories">
                Stories
            </a>

            <a href="/gallery">
                Gallery
            </a>

            <!-- CONTACT BESIDE GALLERY -->

            <a href="/home#contact">
                Contact
            </a>

        </div>


        <button
            class="theme-button"
            onclick="toggleTheme()"
            id="themeButton"
        >
            ☾
        </button>

    </nav>



    <!-- =====================================================
         PAGE CONTENT
    ====================================================== -->

    @yield('content')



    <!-- =====================================================
         FOOTER
    ====================================================== -->

    <footer>

        © {{ date('Y') }} ISRAT.

    </footer>



    <!-- =====================================================
         JAVASCRIPT
    ====================================================== -->

    <script>


        /* =================================================
           DARK MODE
        ================================================= */

        function toggleTheme() {

            document.body.classList.toggle('dark');

            const button =
                document.getElementById(
                    'themeButton'
                );


            if (
                document.body.classList.contains('dark')
            ) {

                button.innerHTML = '☀';

                localStorage.setItem(
                    'theme',
                    'dark'
                );

            } else {

                button.innerHTML = '☾';

                localStorage.setItem(
                    'theme',
                    'light'
                );
            }
        }


        /* =================================================
           LOAD SAVED THEME
        ================================================= */

        if (
            localStorage.getItem('theme')
            ===
            'dark'
        ) {

            document.body.classList.add('dark');

            document.getElementById(
                'themeButton'
            ).innerHTML = '☀';
        }



        /* =================================================
           CURSOR
        ================================================= */

        const cursorGlow =
            document.getElementById(
                'cursorGlow'
            );

        const cursorDot =
            document.getElementById(
                'cursorDot'
            );


        let mouseX = 0;

        let mouseY = 0;

        let lastTrail = 0;


        document.addEventListener(
            'mousemove',
            function(event) {

                mouseX =
                    event.clientX;

                mouseY =
                    event.clientY;


                cursorGlow.style.left =
                    mouseX + 'px';

                cursorGlow.style.top =
                    mouseY + 'px';


                cursorDot.style.left =
                    mouseX + 'px';

                cursorDot.style.top =
                    mouseY + 'px';


                const now =
                    performance.now();


                if (
                    now - lastTrail > 45
                ) {

                    createTrail(
                        mouseX,
                        mouseY
                    );

                    lastTrail = now;
                }

            },
            {
                passive: true
            }
        );



        /* =================================================
           TRAIL
        ================================================= */

        function createTrail(x,y) {

            const trail =
                document.createElement(
                    'div'
                );

            trail.className =
                'glow-trail';

            trail.style.left =
                x + 'px';

            trail.style.top =
                y + 'px';

            document.body.appendChild(
                trail
            );


            setTimeout(
                () => trail.remove(),
                700
            );
        }



        /* =================================================
           CLICK RIPPLE
        ================================================= */

        document.addEventListener(
            'click',
            function(event) {

                createRipple(
                    event.clientX,
                    event.clientY
                );

            }
        );



        /* =================================================
           TOUCH
        ================================================= */

        document.addEventListener(
            'touchstart',
            function(event) {

                for (
                    let i = 0;
                    i < event.touches.length;
                    i++
                ) {

                    const touch =
                        event.touches[i];


                    createRipple(
                        touch.clientX,
                        touch.clientY
                    );


                    createParticles(
                        touch.clientX,
                        touch.clientY
                    );
                }

            },
            {
                passive: true
            }
        );



        /* =================================================
           RIPPLE
        ================================================= */

        function createRipple(x,y) {

            const ripple =
                document.createElement(
                    'div'
                );

            ripple.className =
                'touch-ripple';

            ripple.style.left =
                x + 'px';

            ripple.style.top =
                y + 'px';

            document.body.appendChild(
                ripple
            );


            setTimeout(
                () => ripple.remove(),
                800
            );
        }



        /* =================================================
           TOUCH PARTICLES
        ================================================= */

        function createParticles(x,y) {

            const amount = 8;


            for (
                let i = 0;
                i < amount;
                i++
            ) {

                const particle =
                    document.createElement(
                        'div'
                    );


                particle.className =
                    'touch-particle';


                particle.style.left =
                    x + 'px';


                particle.style.top =
                    y + 'px';


                const angle =
                    (
                        Math.PI * 2
                        / amount
                    ) * i;


                const distance =
                    30 +
                    Math.random() * 45;


                particle.style.setProperty(
                    '--move-x',
                    Math.cos(angle)
                    * distance
                    + 'px'
                );


                particle.style.setProperty(
                    '--move-y',
                    Math.sin(angle)
                    * distance
                    + 'px'
                );


                document.body.appendChild(
                    particle
                );


                setTimeout(
                    () => particle.remove(),
                    700
                );
            }
        }



        /* =================================================
           CARD INTERACTION
        ================================================= */

        document
            .querySelectorAll('.card')
            .forEach(
                function(card) {


                    card.addEventListener(
                        'mousemove',
                        function(event) {

                            const rect =
                                card.getBoundingClientRect();


                            const x =
                                event.clientX
                                - rect.left;


                            const y =
                                event.clientY
                                - rect.top;


                            card.style.setProperty(
                                '--mouse-x',
                                x + 'px'
                            );


                            card.style.setProperty(
                                '--mouse-y',
                                y + 'px'
                            );


                            const rotateX =
                                (
                                    y /
                                    rect.height
                                    - .5
                                ) * -3;


                            const rotateY =
                                (
                                    x /
                                    rect.width
                                    - .5
                                ) * 3;


                            card.style.transform =
                                `
                                translateY(-7px)
                                rotateX(${rotateX}deg)
                                rotateY(${rotateY}deg)
                                `;
                        }
                    );


                    card.addEventListener(
                        'mouseleave',
                        function() {

                            card.style.transform =
                                '';
                        }
                    );


                    /* Mobile */

                    card.addEventListener(
                        'touchstart',
                        function() {

                            card.style.transform =
                                'scale(.985)';

                            card.style.boxShadow =
                                `
                                0 0 35px
                                rgba(180,119,82,.15)
                                `;
                        },
                        {
                            passive:true
                        }
                    );


                    card.addEventListener(
                        'touchend',
                        function() {

                            card.style.transform =
                                '';

                            card.style.boxShadow =
                                '';
                        }
                    );

                }
            );



        /* =================================================
           SCROLL REVEAL
        ================================================= */

        const observer =
            new IntersectionObserver(
                function(entries) {

                    entries.forEach(
                        function(entry) {

                            if (
                                entry.isIntersecting
                            ) {

                                entry.target
                                    .classList
                                    .add('show');
                            }

                        }
                    );

                },
                {
                    threshold:.12
                }
            );


        document
            .querySelectorAll('.card')
            .forEach(
                card =>
                    observer.observe(card)
            );

    </script>


</body>

</html>