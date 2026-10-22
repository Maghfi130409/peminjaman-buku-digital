<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RuangBaca') | Perpustakaan Sekolah</title>

    <style>
        :root {
            --green: #245c45;
            --green-dark: #163d2e;
            --green-light: #e5eee6;
            --cream: #f8f6ef;
            --white: #ffffff;
            --text: #24352c;
            --muted: #728078;
            --border: #e2e6df;
            --red: #b94343;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at 8% 8%, rgba(83,143,98,.12), transparent 28rem),
                radial-gradient(circle at 92% 35%, rgba(190,207,165,.2), transparent 30rem),
                var(--cream);
            background-size: 140% 140%;
            color: var(--text);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            line-height: 1.6;
            animation: backgroundDrift 18s ease-in-out infinite alternate;
        }

        @keyframes backgroundDrift {
            0% {
                background-position: 0% 0%, 100% 30%;
            }
            100% {
                background-position: 35% 20%, 70% 80%;
            }
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button, input, select, textarea {
            font: inherit;
        }

        /* NAVBAR */

        .navbar {
            background: rgba(255,255,255,.96);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 20;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            transition: background .3s ease, box-shadow .3s ease;
        }

        .navbar.scrolled {
            background: rgba(255,255,255,.88);
            box-shadow: 0 10px 30px rgba(22,61,46,.12);
        }

        .nav-inner {
            max-width: 1180px;
            margin: auto;
            padding: 15px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            transition: padding .3s ease;
        }

        .navbar.scrolled .nav-inner {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .brand {
            display: inline-block;
            color: var(--green);
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -.8px;
            transition: transform .25s ease;
        }

        .brand:hover {
            transform: translateY(-2px) scale(1.03);
        }

        .brand span {
            color: #6eaa78;
        }

        .nav-links {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
        }

        .nav-links a {
            font-size: 14px;
            font-weight: 600;
        }

        .nav-links a:not(.btn) {
            position: relative;
            transition: color .25s ease;
        }

        .nav-links a:not(.btn)::after {
            content: "";
            position: absolute;
            left: 0;
            right: 100%;
            bottom: -5px;
            height: 2px;
            border-radius: 5px;
            background: #6eaa78;
            transition: right .25s ease;
        }

        .nav-links a:not(.btn):hover {
            color: var(--green);
        }

        .nav-links a:not(.btn):hover::after {
            right: 0;
        }

        /* CONTAINER */

        .container {
            width: min(1180px, calc(100% - 40px));
            margin: 32px auto 60px;
        }

        /* HERO */

        .hero {
            position: relative;
            isolation: isolate;
            background: linear-gradient(
                125deg,
                #163d2e,
                #357552,
                #47875b,
                #245c45
            );
            background-size: 250% 250%;
            color: white;
            padding: 48px;
            border-radius: 24px;
            margin-bottom: 32px;
            overflow: hidden;
            box-shadow: 0 18px 45px rgba(22,61,46,.17);
            animation: heroGradient 10s ease infinite, riseIn .8s both;
        }

        .hero::before,
        .hero::after {
            content: "";
            position: absolute;
            z-index: -1;
            pointer-events: none;
            border-radius: 50%;
        }

        .hero::before {
            width: 260px;
            height: 260px;
            right: -65px;
            top: -100px;
            background: rgba(220,245,220,.12);
            border: 1px solid rgba(255,255,255,.17);
            animation: floatOrb 8s ease-in-out infinite;
        }

        .hero::after {
            width: 150px;
            height: 150px;
            right: 160px;
            bottom: -95px;
            background: rgba(220,245,220,.09);
            animation: floatOrb 6s ease-in-out infinite reverse;
        }

        @keyframes heroGradient {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes floatOrb {
            0%, 100% {
                transform: translate(0,0) scale(1);
            }
            50% {
                transform: translate(-14px,18px) scale(1.06);
            }
        }

        @keyframes riseIn {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero h1 {
            font-size: clamp(30px, 4vw, 48px);
            line-height: 1.15;
            max-width: 650px;
            margin: 0 0 14px;
        }

        .hero p {
            max-width: 600px;
            color: #e1ece4;
        }

        .hero-tag {
            color: #cce4d1;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* SECTION */

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin: 26px 0 18px;
            animation: riseIn .6s both;
        }

        .section-head h1,
        .section-head h2 {
            margin: 0;
        }

        /* GRID DAN KARTU */

        .grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .card {
            position: relative;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 8px 28px rgba(29,55,38,.035);
            transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            animation: riseIn .65s both;
        }

        .grid .card:nth-child(4n + 1) {
            animation-delay: .04s;
        }

        .grid .card:nth-child(4n + 2) {
            animation-delay: .10s;
        }

        .grid .card:nth-child(4n + 3) {
            animation-delay: .16s;
        }

        .grid .card:nth-child(4n) {
            animation-delay: .22s;
        }

        .card:hover {
            transform: translateY(-8px);
            border-color: rgba(53,117,82,.35);
            box-shadow: 0 18px 38px rgba(29,55,38,.13);
        }

        .book-cover {
            width: 100%;
            aspect-ratio: 3 / 4;
            object-fit: cover;
            border-radius: 12px;
            background: var(--green-light);
            margin-bottom: 12px;
            transition: transform .4s ease, filter .4s ease;
        }

        .card:hover .book-cover {
            transform: scale(1.025);
            filter: saturate(1.08);
        }

        .cover-placeholder {
            aspect-ratio: 3 / 4;
            display: grid;
            place-items: center;
            background: var(--green-light);
            color: var(--green);
            border-radius: 12px;
            margin-bottom: 12px;
            font-size: 46px;
            transition: background .3s ease, transform .3s ease;
        }

        .card:hover .cover-placeholder {
            background: #d8e9da;
            transform: scale(1.02);
        }

        .book-title {
            font-weight: 800;
            line-height: 1.35;
            margin: 6px 0;
        }

        .muted {
            color: var(--muted);
            font-size: 14px;
        }

        .small {
            font-size: 12px;
        }

        .price {
            font-weight: 700;
        }

        /* TOMBOL */

        .btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border: 0;
            border-radius: 10px;
            padding: 10px 16px;
            background: var(--green);
            color: white;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            overflow: hidden;
            transition: transform .2s ease, background .25s ease, box-shadow .25s ease;
        }

        .btn::after {
            content: "";
            position: absolute;
            top: -60%;
            left: -80%;
            width: 45%;
            height: 220%;
            transform: rotate(25deg);
            background: rgba(255,255,255,.25);
            transition: left .55s ease;
            pointer-events: none;
        }

        .btn:hover {
            background: var(--green-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(22,61,46,.16);
        }

        .btn:hover::after {
            left: 140%;
        }

        .btn:active,
        .btn.button-pressed {
            transform: scale(.97);
        }

        .btn-light {
            background: var(--green-light);
            color: var(--green);
        }

        .btn-light:hover {
            background: #d6e7d8;
            color: var(--green-dark);
        }

        .btn-danger {
            background: var(--red);
            color: white;
        }

        .btn-outline {
            background: white;
            color: var(--green);
            border: 1px solid var(--border);
        }

        /* FORM */

        .form-control {
            width: 100%;
            border: 1px solid #d7ded5;
            border-radius: 10px;
            padding: 11px 12px;
            background: white;
            color: var(--text);
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #4c8b61;
            box-shadow: 0 0 0 4px rgba(76,139,97,.13);
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .field {
            margin-bottom: 16px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .search {
            display: flex;
            gap: 10px;
            width: 100%;
            max-width: 540px;
        }

        /* NOTIFIKASI */

        .alert {
            padding: 13px 16px;
            border-radius: 12px;
            margin-bottom: 18px;
            background: #e3f3e6;
            color: #215e37;
            box-shadow: 0 8px 22px rgba(29,55,38,.06);
            animation: alertIn .45s ease both;
        }

        .alert-error {
            background: #fbe8e8;
            color: #8c2525;
        }

        .errors {
            color: #b42318;
            font-size: 13px;
            margin-top: 5px;
        }

        @keyframes alertIn {
            from {
                opacity: 0;
                transform: translateY(-10px) scale(.985);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* TABEL */

        .table-wrap {
            overflow-x: auto;
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 620px;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f2f5ef;
            font-size: 13px;
        }

        td {
            font-size: 14px;
        }

        .badge {
            display: inline-block;
            border-radius: 999px;
            padding: 4px 10px;
            background: #edf0ed;
            font-size: 12px;
            font-weight: 800;
        }

        .badge-pending {
            background: #fff0ca;
            color: #835d00;
        }

        .badge-approved {
            background: #dff3e4;
            color: #22633a;
        }

        .badge-rejected {
            background: #fbe1e1;
            color: #992f2f;
        }

        .badge-returned {
            background: #e5e9f7;
            color: #3d4d8c;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .inline-form {
            display: inline;
        }

        .stack {
            display: grid;
            gap: 14px;
        }

        .auth-card {
            max-width: 480px;
            margin: 40px auto;
        }

        .pagination {
            margin-top: 22px;
        }

        .pagination nav {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 8px;
            background: white;
            border: 1px solid var(--border);
        }

        /* ANIMASI SCROLL */

        .reveal {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity .65s ease, transform .65s cubic-bezier(.2,.7,.2,1);
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* FOOTER RUANGBACA */

        .site-footer {
            position: relative;
            margin-top: 80px;
            padding: 55px 24px 20px;
            color: #e7f0e8;
            background: linear-gradient(135deg, #163d2e, #245c45, #163d2e);
            background-size: 200% 200%;
            animation: footerGradient 12s ease infinite;
            overflow: hidden;
        }

        .site-footer::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            top: -180px;
            right: 8%;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 50%;
            box-shadow:
                0 0 0 35px rgba(255,255,255,.025),
                0 0 0 70px rgba(255,255,255,.02);
            pointer-events: none;
        }

        @keyframes footerGradient {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        .footer-container {
            position: relative;
            max-width: 1180px;
            margin: auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 45px;
            padding-bottom: 35px;
        }

        .footer-brand {
            display: inline-block;
            margin-bottom: 12px;
            color: #fff;
            font-size: 27px;
            font-weight: 800;
            letter-spacing: -.8px;
            transition: transform .25s ease, color .25s ease;
        }

        .footer-brand:hover {
            color: #bce5bf;
            transform: translateY(-3px);
        }

        .footer-brand span {
            color: #9fd4a6;
        }

        .footer-description {
            max-width: 360px;
            margin: 0;
            color: #c5d9cb;
            font-size: 14px;
            line-height: 1.9;
        }

        .footer-title {
            margin: 5px 0 17px;
            color: #fff;
            font-size: 15px;
            font-weight: 800;
        }

        .footer-links {
            display: grid;
            gap: 11px;
        }

        .footer-links a {
            width: fit-content;
            color: #c5d9cb;
            font-size: 14px;
            transition: color .25s ease, transform .25s ease;
        }

        .footer-links a:hover {
            color: #fff;
            transform: translateX(5px);
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,.15);
            color: #c5d9cb;
            font-size: 12px;
        }

        .footer-bottom p {
            margin: 0;
        }

        .footer-highlight {
            color: #bce5bf;
            font-weight: 700;
        }

        /* RESPONSIVE */

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .hero {
                padding: 32px 24px;
            }

            .footer-grid {
                gap: 30px;
            }
        }

        @media (max-width: 700px) {
            .site-footer {
                margin-top: 55px;
                padding: 40px 20px 18px;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 30px 20px;
            }

            .footer-about {
                grid-column: 1 / -1;
            }

            .footer-bottom {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 600px) {
            .nav-inner {
                align-items: flex-start;
                flex-direction: column;
                padding: 14px 20px;
            }

            .nav-links {
                gap: 12px;
            }

            .container {
                width: calc(100% - 28px);
                margin-top: 20px;
            }

            .grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .card {
                padding: 12px;
            }

            .card:hover {
                transform: translateY(-4px);
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .search {
                flex-direction: column;
            }

            .hero h1 {
                font-size: 30px;
            }

            .hero::before {
                width: 170px;
                height: 170px;
                right: -65px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>
    <header class="navbar">
        <div class="nav-inner">
            <a href="{{ route('books.index') }}" class="brand">
                RuangBaca<span>.</span>
            </a>

            <nav class="nav-links">
                <a href="{{ route('books.index') }}">Katalog</a>

                @auth
                    <a href="{{ route('cart.index') }}">
                        Keranjang ({{ count(session('cart', [])) }})
                    </a>

                    <a href="{{ route('borrowings.index') }}">
                        Peminjaman Saya
                    </a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.borrowings.index') }}">
                            Panel Admin
                        </a>

                        <a href="{{ route('admin.books.index') }}">
                            Kelola Buku
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="inline-form">
                        @csrf
                        <button class="btn btn-light" type="submit">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Masuk</a>
                    <a href="{{ route('register') }}" class="btn">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="container">
        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <strong>Periksa kembali:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-grid">

                <div class="footer-about">
                    <a href="{{ route('books.index') }}" class="footer-brand">
                        RuangBaca<span>.</span>
                    </a>

                    <p class="footer-description">
                        Temukan buku favoritmu, ajukan peminjaman dengan mudah,
                        dan jelajahi dunia pengetahuan melalui perpustakaan
                        digital sekolah.
                    </p>
                </div>

                <div>
                    <h3 class="footer-title">Navigasi</h3>

                    <div class="footer-links">
                        <a href="{{ route('books.index') }}">Katalog Buku</a>

                        @auth
                            <a href="{{ route('cart.index') }}">Keranjang</a>
                            <a href="{{ route('borrowings.index') }}">
                                Peminjaman Saya
                            </a>
                        @else
                            <a href="{{ route('login') }}">Masuk</a>
                            <a href="{{ route('register') }}">Daftar Akun</a>
                        @endauth
                    </div>
                </div>

                <div>
                    <h3 class="footer-title">Layanan</h3>

                    <div class="footer-links">
                        <a href="{{ route('books.index') }}">Jelajahi Buku</a>
                        <a href="{{ route('books.index') }}">Cari Buku</a>

                        @auth
                            <a href="{{ route('borrowings.index') }}">
                                Riwayat Peminjaman
                            </a>
                        @else
                            <a href="{{ route('login') }}">Ajukan Peminjaman</a>
                        @endauth
                    </div>
                </div>

            </div>

            <div class="footer-bottom">
                <p>
                    &copy; {{ date('Y') }}
                    <span class="footer-highlight">RuangBaca</span>.
                    Sistem Peminjaman Buku Digital Sekolah.
                </p>

                <p>Dibuat untuk mendukung budaya literasi.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Efek navbar saat halaman digulir
            const navbar = document.querySelector('.navbar');

            function updateNavbar() {
                if (navbar) {
                    navbar.classList.toggle('scrolled', window.scrollY > 12);
                }
            }

            updateNavbar();

            window.addEventListener('scroll', updateNavbar, {
                passive: true
            });

            // Animasi elemen ketika masuk ke area layar
            const revealTargets = document.querySelectorAll(
                '.container > *, .container .section-head, .container .grid, ' +
                '.container .table-wrap, .container .auth-card, .container form.card'
            );

            revealTargets.forEach(function (element) {
                if (
                    !element.classList.contains('hero') &&
                    !element.classList.contains('alert') &&
                    !element.classList.contains('reveal')
                ) {
                    element.classList.add('reveal');
                }
            });

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.08
                });

                document.querySelectorAll('.reveal').forEach(function (element) {
                    observer.observe(element);
                });
            } else {
                document.querySelectorAll('.reveal').forEach(function (element) {
                    element.classList.add('is-visible');
                });
            }

            // Efek tekan pada tombol
            document.querySelectorAll('button.btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    if (!button.disabled) {
                        button.classList.add('button-pressed');

                        window.setTimeout(function () {
                            button.classList.remove('button-pressed');
                        }, 180);
                    }
                });
            });
        });
    </script>
</body>
</html>