
@extends('layouts.app')

@section('title', 'Katalog Buku | RuangBaca Digital')

@section('content')
<style>
    .rb-page {
        --green: #16794c;
        --dark: #103b2c;
        --light: #eaf7ed;
        --text: #203b2b;
        --muted: #77877d;
        position: relative;
        isolation: isolate;
        padding: 16px 0 50px;
        color: var(--text);
        overflow: hidden;
    }

    .rb-page *,
    .rb-page *::before,
    .rb-page *::after {
        box-sizing: border-box;
    }

    .rb-page a {
        -webkit-tap-highlight-color: transparent;
    }

    /* BACKGROUND */
    .rb-background {
        position: absolute;
        inset: 0;
        z-index: -1;
        overflow: hidden;
        pointer-events: none;
    }

    .rb-orb {
        position: absolute;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        background: #8ce8b3;
        filter: blur(85px);
        opacity: .32;
        animation: rb-glow 13s ease-in-out infinite alternate;
    }

    .rb-orb.one {
        top: 100px;
        left: -170px;
    }

    .rb-orb.two {
        top: 650px;
        right: -180px;
        background: #b5e8c5;
        animation-delay: -4s;
    }

    .rb-orb.three {
        top: 1300px;
        left: 35%;
        background: #00ff40;
        animation-delay: -7s;
    }

    .rb-particle {
        position: absolute;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #51b77d;
        box-shadow: 0 0 17px #51b77d;
        opacity: .5;
        animation: rb-particle 7s ease-in-out infinite;
    }

    .rb-particle.p1 { top: 8%; left: 8%; }
    .rb-particle.p2 { top: 20%; right: 12%; animation-delay: -2s; }
    .rb-particle.p3 { top: 43%; left: 15%; animation-delay: -4s; }
    .rb-particle.p4 { top: 65%; right: 8%; animation-delay: -1s; }
    .rb-particle.p5 { top: 87%; left: 55%; animation-delay: -3s; }

    /* DAUN HIJAU */
    .rb-leaf {
        position: absolute;
        width: 85px;
        height: 85px;
        color: #278451;
        opacity: .17;
        filter: drop-shadow(0 8px 12px #237b4820);
        animation: rb-leaf-float 9s ease-in-out infinite;
    }

    .rb-leaf.leaf-one {
        top: 5%;
        right: 5%;
        width: 110px;
        height: 110px;
        transform: rotate(-25deg);
    }

    .rb-leaf.leaf-two {
        top: 29%;
        left: 2%;
        width: 75px;
        height: 75px;
        animation-delay: -3s;
    }

    .rb-leaf.leaf-three {
        top: 49%;
        right: 3%;
        width: 125px;
        height: 125px;
        animation-delay: -5s;
    }

    .rb-leaf.leaf-four {
        top: 72%;
        left: 6%;
        width: 100px;
        height: 100px;
        animation-delay: -2s;
    }

    .rb-leaf.leaf-five {
        top: 91%;
        right: 12%;
        width: 75px;
        height: 75px;
        animation-delay: -6s;
    }

    @keyframes rb-glow {
        from { transform: translate(0, 0) scale(1); }
        to { transform: translate(30px, -25px) scale(1.12); }
    }

    @keyframes rb-particle {
        0%, 100% { transform: translateY(0); opacity: .3; }
        50% { transform: translateY(-22px); opacity: .8; }
    }

    @keyframes rb-leaf-float {
        0%, 100% { translate: 0 0; rotate: -8deg; }
        50% { translate: 8px -18px; rotate: 8deg; }
    }

    @keyframes rb-enter {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes rb-float {
        0%, 100% { transform: translateY(0) rotate(-5deg); }
        50% { transform: translateY(-13px) rotate(-2deg); }
    }

    @keyframes rb-shine {
        from { transform: translateX(-150%) skewX(-20deg); }
        to { transform: translateX(350%) skewX(-20deg); }
    }

    @keyframes rb-ring {
        to { transform: rotate(360deg); }
    }

    /* HERO */
    .rb-hero {
        position: relative;
        display: grid;
        grid-template-columns: 1.15fr .85fr;
        align-items: center;
        gap: 25px;
        min-height: 390px;
        padding: clamp(26px, 5vw, 55px);
        overflow: hidden;
        border: 1px solid #ffffff35;
        border-radius: 30px;
        color: white;
        background: linear-gradient(125deg, #103b2c 0%, #16794c 55%, #247653 100%);
        box-shadow: 0 25px 70px #164c3226;
        animation: rb-enter .8s ease both;
    }

    .rb-hero::before {
        content: "";
        position: absolute;
        top: -180px;
        right: 8%;
        width: 400px;
        height: 400px;
        border: 1px solid #ffffff35;
        border-radius: 50%;
        box-shadow: 0 0 0 35px #ffffff08,
                    0 0 0 75px #ffffff07,
                    0 0 0 115px #ffffff05;
        animation: rb-ring 45s linear infinite;
        pointer-events: none;
    }

    .rb-hero::after {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 40%;
        height: 100%;
        background: linear-gradient(90deg, transparent, #ffffff15, transparent);
        animation: rb-shine 8s ease-in-out infinite;
        pointer-events: none;
    }

    .rb-hero-content {
        position: relative;
        z-index: 2;
    }

    .rb-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 10px 15px;
        border: 1px solid #ffffff45;
        border-radius: 50px;
        background: #ffffff17;
        color: #edfff3;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.6px;
        backdrop-filter: blur(15px);
    }

    .rb-live-dot {
        width: 8px;
        height: 8px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #83ffad;
        box-shadow: 0 0 12px #83ffad;
    }

    .rb-hero h1 {
        max-width: 620px;
        margin: 22px 0 17px;
        color: #fff;
        font-size: clamp(34px, 4.5vw, 57px);
        font-weight: 900;
        line-height: 1.08;
        letter-spacing: -1.8px;
    }

    .rb-hero h1 span {
        color: #b8ffd0;
        text-shadow: 0 0 30px #80ffb744;
    }

    .rb-hero-description {
        max-width: 520px;
        margin: 0;
        color: #e5f8ed;
        font-size: 15px;
        line-height: 1.9;
    }

    .rb-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 27px;
    }

    .rb-hero-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 49px;
        padding: 0 19px;
        border: 1px solid #ffffff65;
        border-radius: 14px;
        background: #fff;
        color: #15543a !important;
        font-size: 13px;
        font-weight: 850;
        text-decoration: none !important;
        transition: transform .25s, box-shadow .25s, background .25s;
    }

    .rb-hero-button:hover {
        transform: translateY(-4px);
        background: #dffff0;
        box-shadow: 0 13px 28px #082c2040;
    }

    .rb-hero-note {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-top: 23px;
        color: #e0f5e7;
        font-size: 12px;
    }

    /* ILUSTRASI BUKU */
    .rb-visual {
        position: relative;
        display: grid;
        place-items: center;
        min-height: 285px;
        perspective: 1000px;
    }

    .rb-visual-halo {
        position: absolute;
        width: 230px;
        height: 230px;
        border: 1px solid #ffffff38;
        border-radius: 50%;
        box-shadow: 0 0 65px #b2ffcf1b, inset 0 0 55px #ffffff0b;
    }

    .rb-visual-halo::before,
    .rb-visual-halo::after {
        content: "";
        position: absolute;
        border: 1px dashed #ffffff45;
        border-radius: 50%;
        inset: -28px;
        animation: rb-ring 25s linear infinite;
    }

    .rb-visual-halo::after {
        inset: 25px;
        animation-direction: reverse;
        animation-duration: 18s;
    }

    .rb-book-stack {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transform-style: preserve-3d;
        animation: rb-float 5s ease-in-out infinite;
        filter: drop-shadow(0 25px 24px #062c2c55);
    }

    .rb-book-art {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: clamp(64px, 7vw, 94px);
        height: clamp(112px, 12vw, 158px);
        border-left: 6px solid #00000020;
        border-radius: 5px 12px 12px 5px;
        box-shadow: inset -8px 0 12px #0000000c, 0 12px 22px #092e2930;
        font-size: 35px;
        transition: transform .35s;
    }

    .rb-book-art small {
        margin-top: 14px;
        font-size: 9px;
        font-weight: 900;
        letter-spacing: 1px;
    }

    .rb-book-art:nth-child(1) {
        color: #694719;
        background: linear-gradient(145deg, #ffe6a7, #e7ae54);
        transform: translateY(15px) rotate(-12deg);
    }

    .rb-book-art:nth-child(2) {
        color: #245b3b;
        background: linear-gradient(145deg, #efffe7, #b6e6c1);
        transform: translateY(-12px);
    }

    .rb-book-art:nth-child(3) {
        color: #245b3b;
        background: linear-gradient(145deg, #c8f5d5, #83cfa0);
        transform: translateY(12px) rotate(11deg);
    }

    .rb-book-stack:hover .rb-book-art:nth-child(1) {
        transform: translateY(0) rotate(-19deg);
    }

    .rb-book-stack:hover .rb-book-art:nth-child(2) {
        transform: translateY(-25px);
    }

    .rb-book-stack:hover .rb-book-art:nth-child(3) {
        transform: translateY(0) rotate(18deg);
    }

    .rb-floating-label {
        position: absolute;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 11px 14px;
        border: 1px solid #ffffff45;
        border-radius: 14px;
        background: #ffffff20;
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        backdrop-filter: blur(14px);
        box-shadow: 0 10px 25px #062c2020;
    }

    .rb-floating-label.label-one {
        top: 13%;
        right: -1%;
        animation: rb-float 4s ease-in-out infinite;
    }

    .rb-floating-label.label-two {
        bottom: 12%;
        left: -2%;
        animation: rb-float 5s ease-in-out infinite reverse;
    }

    /* STATISTIK */
    .rb-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 17px;
        margin: 25px 0 45px;
    }

    .rb-stat {
        position: relative;
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 0;
        padding: 23px;
        overflow: hidden;
        border: 1px solid #e1ebe3;
        border-radius: 21px;
        background: #ffffffed;
        box-shadow: 0 9px 30px #214a3008;
        animation: rb-enter .7s ease both;
        transition: transform .3s, box-shadow .3s, border-color .3s;
    }

    .rb-stat:nth-child(2) { animation-delay: .12s; }
    .rb-stat:nth-child(3) { animation-delay: .24s; }

    .rb-stat::after {
        content: "";
        position: absolute;
        right: -42px;
        bottom: -55px;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: #a8e5bc;
        opacity: .2;
        transition: transform .4s;
    }

    .rb-stat:hover {
        transform: translateY(-7px);
        border-color: #7fc69a;
        box-shadow: 0 20px 40px #214a3018;
    }

    .rb-stat:hover::after {
        transform: scale(1.6);
    }

    .rb-stat-icon {
        position: relative;
        z-index: 1;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 55px;
        height: 55px;
        border-radius: 17px;
        background: #e5f5e9;
        font-size: 25px;
    }

    .rb-stat-info {
        position: relative;
        z-index: 1;
        min-width: 0;
    }

    .rb-stat-number {
        color: var(--green);
        font-size: clamp(23px, 2.5vw, 32px);
        font-weight: 900;
        line-height: 1.2;
        overflow-wrap: anywhere;
    }

    .rb-stat-label {
        margin-top: 5px;
        color: var(--muted);
        font-size: 12px;
        line-height: 1.6;
    }

    /* JUDUL KOLEKSI */
    .rb-section-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
        scroll-margin-top: 100px;
    }

    .rb-section-kicker {
        margin-bottom: 7px;
        color: var(--green);
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .rb-section-heading h2 {
        position: relative;
        display: inline-block;
        margin: 0;
        padding-bottom: 10px;
        color: #1b3929;
        font-size: clamp(25px, 3vw, 34px);
        font-weight: 900;
        letter-spacing: -.8px;
    }

    .rb-section-heading h2::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 55px;
        height: 4px;
        border-radius: 9px;
        background: var(--green);
        transition: width .3s;
    }

    .rb-section-heading h2:hover::after {
        width: 100%;
    }

    .rb-section-subtitle {
        margin-top: 10px;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .rb-result-count {
        flex-shrink: 0;
        padding: 9px 13px;
        border: 1px solid #d9e9dd;
        border-radius: 30px;
        background: #f0faf2;
        color: #267449;
        font-size: 12px;
        font-weight: 800;
    }

    /* PENCARIAN */
    .rb-search-panel {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 25px;
        padding: 12px;
        border: 1px solid #e2ebe3;
        border-radius: 18px;
        background: #ffffffed;
        box-shadow: 0 8px 28px #214a3008;
    }

    .rb-search-icon {
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 43px;
        height: 43px;
        border-radius: 13px;
        background: #eaf7ed;
        color: var(--green);
        font-size: 23px;
    }

    .rb-search-panel input {
        flex: 1;
        width: 100%;
        min-width: 0;
        min-height: 44px;
        padding: 10px 12px;
        border: 1px solid transparent;
        border-radius: 10px;
        outline: none;
        background: transparent;
        color: var(--text);
        font: inherit;
        font-size: 13px;
        transition: border-color .2s, background .2s, box-shadow .2s;
    }

    .rb-search-panel input::placeholder {
        color: #9aa79e;
    }

    .rb-search-panel input:focus {
        border-color: #9bceb0;
        background: #f8fff9;
        box-shadow: 0 0 0 3px #2d9d6317;
    }

    .rb-search-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 0 20px;
        border: 0;
        border-radius: 12px;
        background: var(--green);
        color: #fff;
        font-size: 13px;
        font-weight: 850;
        cursor: pointer;
        transition: transform .25s, box-shadow .25s, background .25s;
    }

    .rb-search-submit:hover {
        transform: translateY(-2px);
        background: var(--dark);
        box-shadow: 0 8px 20px #16794c35;
    }

    .rb-search-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 0 14px;
        border: 1px solid #dce8df;
        border-radius: 12px;
        background: #fff;
        color: #267448 !important;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none !important;
    }

    .rb-search-reset:hover {
        background: #edf8ef;
    }

    /* KARTU BUKU */
    .rb-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 21px;
    }

    .rb-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        padding: 12px;
        overflow: hidden;
        border: 1px solid #e2eae3;
        border-radius: 21px;
        background: #ffffffed;
        box-shadow: 0 8px 25px #214a3009;
        animation: rb-enter .65s ease both;
        transition: transform .32s, box-shadow .32s, border-color .32s;
    }

    .rb-card::before {
        content: "";
        position: absolute;
        z-index: 2;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: #25845a;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .35s;
    }

    .rb-card:hover {
        transform: translateY(-8px);
        border-color: #8ac9a0;
        box-shadow: 0 20px 42px #214a301b;
    }

    .rb-card:hover::before {
        transform: scaleX(1);
    }

    .rb-card-link {
        display: block;
        color: inherit !important;
        text-decoration: none !important;
    }

    .rb-cover-wrap {
        position: relative;
        overflow: hidden;
        border-radius: 14px;
        background: linear-gradient(145deg, #e0f1e4, #c5e1cd);
    }

    .rb-cover {
        display: block;
        width: 100%;
        aspect-ratio: 3 / 4;
        object-fit: cover;
        border-radius: 14px;
        transition: transform .5s, filter .4s;
    }

    .rb-card:hover .rb-cover {
        transform: scale(1.055);
        filter: saturate(1.08);
    }

    .rb-cover-placeholder {
        display: grid;
        place-items: center;
        width: 100%;
        aspect-ratio: 3 / 4;
        color: #24784b;
        font-size: 58px;
    }

    .rb-cover-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 7px 10px;
        border: 1px solid #ffffff80;
        border-radius: 30px;
        background: #ffffffdf;
        color: #285b3e;
        font-size: 10px;
        font-weight: 900;
    }

    .rb-card-body {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 3px 3px 2px;
    }

    .rb-title {
        display: -webkit-box;
        margin-top: 13px;
        overflow: hidden;
        color: #203b2b;
        font-size: 15px;
        font-weight: 850;
        line-height: 1.5;
        overflow-wrap: anywhere;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .rb-author {
        display: -webkit-box;
        margin-top: 6px;
        overflow: hidden;
        color: var(--muted);
        font-size: 12px;
        line-height: 1.7;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .rb-stock {
        display: flex;
        align-items: center;
        gap: 7px;
        margin: 14px 0;
        color: #21814d;
        font-size: 11px;
        font-weight: 850;
    }

    .rb-stock-dot {
        width: 7px;
        height: 7px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #39b76d;
        box-shadow: 0 0 10px #39b76d70;
    }

    .rb-stock.empty {
        color: #c24747;
    }

    .rb-stock.empty .rb-stock-dot {
        background: #e45d5d;
        box-shadow: 0 0 8px #e45d5d55;
    }

    .rb-detail {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        min-height: 42px;
        margin-top: auto;
        padding: 10px;
        border: 1px solid #d5e6d9;
        border-radius: 12px;
        background: #f4faf5;
        color: #267448 !important;
        font-size: 12px;
        font-weight: 850;
        text-align: center;
        text-decoration: none !important;
        transition: color .25s, background .25s, transform .25s, border-color .25s;
    }

    .rb-detail:hover {
        transform: translateY(-2px);
        border-color: var(--green);
        background: var(--green);
        color: #fff !important;
    }

    /* KOSONG */
    .rb-empty {
        grid-column: 1 / -1;
        padding: 55px 20px;
        border: 1px dashed #c9ddce;
        border-radius: 24px;
        background: #ffffffdf;
        text-align: center;
    }

    .rb-empty-icon {
        display: inline-grid;
        place-items: center;
        width: 90px;
        height: 90px;
        border-radius: 28px;
        background: #e2f6e7;
        font-size: 42px;
        animation: rb-float 4s ease-in-out infinite;
    }

    .rb-empty h3 {
        margin: 20px 0 8px;
        color: #203b2b;
        font-size: 23px;
        font-weight: 900;
    }

    .rb-empty p {
        color: var(--muted);
        font-size: 13px;
        line-height: 1.8;
    }

    .rb-empty-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 12px;
        padding: 12px 18px;
        border-radius: 12px;
        background: var(--green);
        color: #fff !important;
        font-size: 12px;
        font-weight: 850;
        text-decoration: none !important;
        transition: transform .2s, background .2s;
    }

    .rb-empty-link:hover {
        transform: translateY(-2px);
        background: var(--dark);
    }

    /* PAGINATION */
    .rb-pagination {
        display: flex;
        justify-content: center;
        margin-top: 32px;
        overflow-x: auto;
    }

    .rb-pagination nav {
        max-width: 100%;
    }

    .rb-pagination svg {
        width: 18px;
        height: 18px;
    }

    /* RESPONSIF */
    @media (max-width: 1050px) {
        .rb-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .rb-hero {
            gap: 10px;
        }
    }

    @media (max-width: 760px) {
        .rb-page {
            padding-top: 4px;
        }

        .rb-hero {
            grid-template-columns: 1fr;
            min-height: auto;
            padding: 29px 24px;
            border-radius: 23px;
        }

        .rb-hero h1 {
            font-size: clamp(33px, 8vw, 46px);
            letter-spacing: -1px;
        }

        .rb-hero-description {
            font-size: 13px;
        }

        .rb-visual {
            min-height: 230px;
        }

        .rb-visual-halo {
            width: 175px;
            height: 175px;
        }

        .rb-book-art {
            width: 72px;
            height: 120px;
        }

        .rb-floating-label.label-one {
            right: 4%;
        }

        .rb-floating-label.label-two {
            left: 3%;
        }

        .rb-stats {
            grid-template-columns: 1fr;
            gap: 12px;
            margin: 18px 0 37px;
        }

        .rb-stat {
            padding: 18px;
        }

        .rb-section-heading {
            align-items: flex-start;
            flex-direction: column;
            gap: 12px;
        }

        .rb-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 13px;
        }

        .rb-card {
            padding: 9px;
            border-radius: 17px;
        }

        .rb-title {
            font-size: 13px;
        }

        .rb-author,
        .rb-detail {
            font-size: 11px;
        }

        .rb-search-panel {
            gap: 7px;
            padding: 8px;
        }

        .rb-search-icon {
            width: 35px;
            height: 35px;
            font-size: 16px;
        }

        .rb-search-submit {
            padding: 0 13px;
        }

        .rb-leaf.leaf-one {
            width: 75px;
            height: 75px;
        }

        .rb-leaf.leaf-three {
            width: 85px;
            height: 85px;
        }
    }

    @media (max-width: 390px) {
        .rb-grid {
            grid-template-columns: 1fr;
        }

        .rb-card {
            padding: 12px;
        }

        .rb-cover,
        .rb-cover-placeholder {
            aspect-ratio: 4 / 3;
        }

        .rb-search-panel {
            flex-wrap: wrap;
        }

        .rb-search-icon {
            display: none;
        }

        .rb-search-panel input {
            flex-basis: 100%;
        }

        .rb-search-submit,
        .rb-search-reset {
            flex: 1;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .rb-page *,
        .rb-page *::before,
        .rb-page *::after {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
        }
    }
</style>

<div class="rb-page">

    {{-- BACKGROUND --}}
    <div class="rb-background" aria-hidden="true">
        <div class="rb-orb one"></div>
        <div class="rb-orb two"></div>
        <div class="rb-orb three"></div>

        <span class="rb-particle p1"></span>
        <span class="rb-particle p2"></span>
        <span class="rb-particle p3"></span>
        <span class="rb-particle p4"></span>
        <span class="rb-particle p5"></span>

        {{-- Daun dekoratif SVG --}}
        <svg class="rb-leaf leaf-one" viewBox="0 0 100 100" fill="currentColor">
            <path d="M86 9C48 8 17 24 13 53c-3 21 15 34 33 25C72 65 83 34 86 9Z"/>
            <path d="M18 84C35 62 52 43 77 20" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M37 62 33 43M51 48 50 29M47 52 67 54M34 69 22 65" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
        </svg>

        <svg class="rb-leaf leaf-two" viewBox="0 0 100 100" fill="currentColor">
            <path d="M88 12C59 13 27 22 17 47 8 69 24 88 44 80 69 70 83 42 88 12Z"/>
            <path d="M16 87C34 63 53 43 79 22" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M36 64 31 46M50 49 51 32M46 54 66 57" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
        </svg>

        <svg class="rb-leaf leaf-three" viewBox="0 0 100 100" fill="currentColor">
            <path d="M87 10C54 8 22 25 13 51 7 72 22 88 42 80 70 69 83 39 87 10Z"/>
            <path d="M15 87C34 62 54 41 79 20" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M35 65 30 46M50 49 50 30M47 53 67 56M30 72 20 67" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
        </svg>

        <svg class="rb-leaf leaf-four" viewBox="0 0 100 100" fill="currentColor">
            <path d="M86 9C48 8 17 24 13 53c-3 21 15 34 33 25C72 65 83 34 86 9Z"/>
            <path d="M18 84C35 62 52 43 77 20" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M37 62 33 43M51 48 50 29M47 52 67 54" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
        </svg>

        <svg class="rb-leaf leaf-five" viewBox="0 0 100 100" fill="currentColor">
            <path d="M88 12C59 13 27 22 17 47 8 69 24 88 44 80 69 70 83 42 88 12Z"/>
            <path d="M16 87C34 63 53 43 79 22" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M36 64 31 46M50 49 51 32M46 54 66 57" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </div>

    {{-- HERO --}}
    <section class="rb-hero">
        <div class="rb-hero-content">
            <div class="rb-eyebrow">
                <span class="rb-live-dot"></span>
                RUANGBACA DIGITAL
            </div>

            <h1>
                Buka buku.<br>
                Buka dunia <span>baru.</span>
            </h1>

            <p class="rb-hero-description">
                Setiap halaman menyimpan kemungkinan baru. Temukan bacaan
                favoritmu, perluas wawasan, dan jelajahi dunia pengetahuan
                melalui perpustakaan digital sekolah.
            </p>

            <div class="rb-hero-actions">
                <a href="#koleksi" class="rb-hero-button">
                    <span>Jelajahi koleksi</span>
                    <span>↘</span>
                </a>
            </div>

            <div class="rb-hero-note">
                <span>✦</span>
                <span>Satu buku bisa membuka seribu kemungkinan.</span>
            </div>
        </div>

        <div class="rb-visual" aria-hidden="true">
            <div class="rb-visual-halo"></div>

            <div class="rb-book-stack">
                <div class="rb-book-art">📖<small>CERITA</small></div>
                <div class="rb-book-art">📚<small>PENGETAHUAN</small></div>
                <div class="rb-book-art">✨<small>INSPIRASI</small></div>
            </div>

            <div class="rb-floating-label label-one">
                <span>✨</span>
                <span>Temukan inspirasi</span>
            </div>

            <div class="rb-floating-label label-two">
                <span>🌱</span>
                <span>Tumbuh bersama ilmu</span>
            </div>
        </div>
    </section>

    {{-- STATISTIK --}}
    <section class="rb-stats" aria-label="Statistik katalog buku">
        <article class="rb-stat">
            <div class="rb-stat-icon">📚</div>
            <div class="rb-stat-info">
                <div class="rb-stat-number">
                    {{ number_format($totalBooks ?? 0) }}
                </div>
                <div class="rb-stat-label">Total judul buku</div>
            </div>
        </article>

        <article class="rb-stat">
            <div class="rb-stat-icon">🌿</div>
            <div class="rb-stat-info">
                <div class="rb-stat-number">
                    {{ number_format($availableBooks ?? 0) }}
                </div>
                <div class="rb-stat-label">Judul dengan stok tersedia</div>
            </div>
        </article>

        <article class="rb-stat">
            <div class="rb-stat-icon">🔎</div>
            <div class="rb-stat-info">
                <div class="rb-stat-number">
                    {{ number_format($books->total()) }}
                </div>
                <div class="rb-stat-label">Hasil katalog saat ini</div>
            </div>
        </article>
    </section>

    {{-- JUDUL KOLEKSI --}}
    <section id="koleksi" class="rb-section-heading">
        <div>
            <div class="rb-section-kicker">Temukan bacaanmu</div>
            <h2>Jelajahi Koleksi</h2>
            <div class="rb-section-subtitle">
                Pengetahuan baru menunggumu di setiap halaman.
            </div>
        </div>

        <div class="rb-result-count">
            📖 {{ number_format($books->total()) }} buku ditemukan
        </div>
    </section>

    {{-- PENCARIAN --}}
    <form action="{{ route('books.index') }}" method="GET" class="rb-search-panel">
        <div class="rb-search-icon" aria-hidden="true">⌕</div>

        <input
            type="search"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari judul buku atau nama penulis..."
            aria-label="Cari berdasarkan judul atau penulis"
        >

        <button class="rb-search-submit" type="submit">
            <span>⌕</span>
            Cari buku
        </button>

        @if(request()->filled('q'))
            <a class="rb-search-reset" href="{{ route('books.index') }}">
                Reset
            </a>
        @endif
    </form>

    {{-- DAFTAR BUKU --}}
    <div class="rb-grid">
        @forelse($books as $book)
            <article class="rb-card">
                <a class="rb-card-link" href="{{ route('books.show', $book) }}">
                    <div class="rb-cover-wrap">
                        @if($book->cover)
                            <img
                                class="rb-cover"
                                src="{{ asset('storage/' . $book->cover) }}"
                                alt="Sampul {{ $book->title }}"
                                loading="lazy"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
                            >

                            <div
                                class="rb-cover-placeholder"
                                style="display:none;"
                                aria-label="Sampul tidak tersedia"
                            >📚</div>
                        @else
                            <div class="rb-cover-placeholder" aria-label="Tidak ada sampul">
                                📚
                            </div>
                        @endif

                        <span class="rb-cover-badge">RUANGBACA</span>
                    </div>

                    <div class="rb-card-body">
                        <div class="rb-title">{{ $book->title }}</div>

                        <div class="rb-author">
                            ✍️ {{ $book->author ?: 'Penulis tidak diketahui' }}
                        </div>
                    </div>
                </a>

                <div class="rb-stock {{ $book->stock > 0 ? '' : 'empty' }}">
                    <span class="rb-stock-dot"></span>

                    @if($book->stock > 0)
                        Stok tersedia: {{ $book->stock }}
                    @else
                        Stok sedang habis
                    @endif
                </div>

                <a class="rb-detail" href="{{ route('books.show', $book) }}">
                    Lihat detail <span>↗</span>
                </a>
            </article>
        @empty
            <div class="rb-empty">
                <div class="rb-empty-icon">📖</div>

                <h3>
                    @if(request()->filled('q'))
                        Buku belum ditemukan
                    @else
                        Koleksi masih kosong
                    @endif
                </h3>

                <p>
                    @if(request()->filled('q'))
                        Coba kata kunci lain. Mungkin buku yang kamu cari
                        memiliki judul yang berbeda.
                    @else
                        Belum ada buku yang ditampilkan di katalog ini.
                    @endif
                </p>

                @if(request()->filled('q'))
                    <a href="{{ route('books.index') }}" class="rb-empty-link">
                        Tampilkan semua buku ↗
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($books->hasPages())
        <div class="rb-pagination">
            {{ $books->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
