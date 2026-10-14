<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SmaCan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <style>
        :root {
            --teal-950: #021a18;
            --teal-900: #043d38;
            --teal-700: #0a6b60;
            --teal-500: #0d9488;
            --teal-400: #2dd4bf;
            --teal-200: #99f6e4;
            --teal-50:  #f0fdfa;
            --neutral-900: #0f172a;
            --neutral-600: #475569;
            --neutral-300: #cbd5e1;
            --neutral-100: #f1f5f9;
            --neutral-50:  #f8fafc;
            --white: #ffffff;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; font-size: 16px; }
        body { font-family: 'Inter', sans-serif; background: var(--white); color: var(--neutral-900); overflow-x: hidden; -webkit-font-smoothing: antialiased; }

        /* ── NAV ── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 6%;
            height: 76px;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }
        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 800;
            color: var(--neutral-900); text-decoration: none; letter-spacing: -0.3px;
        }
        .logo-mark {
            width: 38px; height: 38px; border-radius: 9px;
            background: var(--teal-500);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .logo-mark svg { width: 19px; height: 19px; fill: none; stroke: #fff; stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round; }
        .nav-links { display: flex; align-items: center; gap: 40px; }
        .nav-links a { font-size: 16px; font-weight: 500; color: var(--neutral-600); text-decoration: none; transition: color 0.15s; }
        .nav-links a:hover { color: var(--neutral-900); }
        .nav-actions { display: flex; align-items: center; gap: 12px; }
        .btn-ghost {
            font-size: 16px; font-weight: 500; color: var(--neutral-600);
            text-decoration: none; padding: 9px 18px; border-radius: 9px;
            transition: background 0.15s, color 0.15s;
        }
        .btn-ghost:hover { background: var(--neutral-100); color: var(--neutral-900); }
        .btn-primary {
            font-size: 16px; font-weight: 600; color: var(--white);
            background: var(--teal-500); text-decoration: none;
            padding: 10px 22px; border-radius: 9px;
            transition: background 0.15s, transform 0.15s;
        }
        .btn-primary:hover { background: var(--teal-700); transform: translateY(-1px); }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            padding: 76px 6% 0;
            display: flex; flex-direction: column; justify-content: center;
            background: var(--white);
            position: relative; overflow: hidden;
        }
        .hero-content { position: relative; z-index: 2; padding-top: 60px; max-width: 640px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 7px;
            font-size: 12px; font-weight: 600; letter-spacing: 0.04em;
            color: var(--teal-700); background: var(--teal-50);
            border: 1px solid rgba(13,148,136,0.2);
            padding: 5px 12px; border-radius: 100px; margin-bottom: 28px;
        }
        .badge-dot { width: 6px; height: 6px; background: var(--teal-500); border-radius: 50%; }
        .hero-h1 {
            font-family: 'Syne', sans-serif;
            font-size: clamp(40px, 5.5vw, 72px);
            font-weight: 800; line-height: 1.08;
            letter-spacing: -0.03em; color: var(--neutral-900);
            margin-bottom: 20px;
        }
        .hero-h1 .accent { color: var(--teal-500); }
        .hero-p {
            font-size: 17px; line-height: 1.75; color: var(--neutral-600);
            max-width: 480px; margin-bottom: 36px;
        }
        .hero-btns { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn-hero {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 14px; font-weight: 600; text-decoration: none;
            padding: 12px 24px; border-radius: 10px;
            transition: all 0.15s;
        }
        .btn-hero-main { background: var(--teal-500); color: #fff; box-shadow: 0 1px 3px rgba(13,148,136,0.3), 0 4px 16px rgba(13,148,136,0.2); }
        .btn-hero-main:hover { background: var(--teal-700); transform: translateY(-1px); box-shadow: 0 4px 20px rgba(13,148,136,0.35); }
        .btn-hero-outline { border: 1.5px solid var(--neutral-300); color: var(--neutral-600); background: var(--white); }
        .btn-hero-outline:hover { border-color: var(--teal-400); color: var(--teal-700); background: var(--teal-50); }

        /* hero right visual */
        .hero-visual {
            position: absolute; right: 5%; top: 50%; transform: translateY(-50%);
            width: 42%; max-width: 540px; z-index: 1;
        }
        .hero-card-stack { position: relative; }
        .hcard {
            background: var(--white); border-radius: 16px;
            border: 1px solid var(--neutral-100);
            box-shadow: 0 4px 24px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04);
            padding: 18px 22px;
        }
        .hcard-main { position: relative; z-index: 3; }
        .hcard-behind-1 {
            position: absolute; top: -14px; left: 16px; right: 16px;
            height: 100%; border-radius: 16px;
            background: var(--teal-50); border: 1px solid rgba(13,148,136,0.15);
            z-index: 2;
        }
        .hcard-behind-2 {
            position: absolute; top: -26px; left: 32px; right: 32px;
            height: 100%; border-radius: 16px;
            background: rgba(13,148,136,0.04); border: 1px solid rgba(13,148,136,0.08);
            z-index: 1;
        }
        .hcard-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .hcard-title { font-size: 13px; font-weight: 600; color: var(--neutral-900); }
        .hcard-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--teal-400); box-shadow: 0 0 0 3px rgba(45,212,191,0.2); }
        .tong-row { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid var(--neutral-100); }
        .tong-row:last-child { border-bottom: none; padding-bottom: 0; }
        .tong-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; }
        .tong-info { flex: 1; }
        .tong-name { font-size: 12.5px; font-weight: 500; color: var(--neutral-900); }
        .tong-loc { font-size: 11px; color: var(--neutral-600); margin-top: 1px; }
        .tong-status { font-size: 11px; font-weight: 600; padding: 3px 9px; border-radius: 6px; }
        .status-ok  { background: #f0fdf4; color: #16a34a; }
        .status-mid { background: #fffbeb; color: #d97706; }
        .status-bad { background: #fef2f2; color: #dc2626; }

        .hcard-footer { margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--neutral-100); display: flex; align-items: center; gap: 8px; }
        .hcard-footer-label { font-size: 11.5px; color: var(--neutral-600); }
        .poin-chip { margin-left: auto; background: var(--teal-50); color: var(--teal-700); font-size: 11.5px; font-weight: 600; padding: 4px 10px; border-radius: 6px; }

        /* floating badge */
        .float-badge {
            position: absolute; bottom: -20px; right: -20px; z-index: 10;
            background: var(--white); border: 1px solid var(--neutral-100);
            border-radius: 12px; padding: 10px 14px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            display: flex; align-items: center; gap: 9px;
        }
        .float-badge-icon { width: 32px; height: 32px; background: #f0fdf4; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #16a34a; font-size: 16px; }
        .float-badge-text { font-size: 12px; }
        .float-badge-num { font-weight: 700; color: var(--neutral-900); font-size: 13px; }
        .float-badge-sub { color: var(--neutral-600); font-size: 11px; }

        /* hero bottom bar */
        .hero-bottom {
            position: relative; z-index: 2;
            display: flex; gap: 0; margin-top: 80px;
            border-top: 1px solid var(--neutral-100);
            padding: 28px 0;
        }
        .hero-stat-item { flex: 1; padding: 0 28px 0 0; }
        .hero-stat-item + .hero-stat-item { padding-left: 28px; border-left: 1px solid var(--neutral-100); }
        .hero-stat-num { font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800; color: var(--neutral-900); letter-spacing: -0.02em; }
        .hero-stat-num span { color: var(--teal-500); }
        .hero-stat-label { font-size: 13px; color: var(--neutral-600); margin-top: 2px; }

        /* ── HOW ── */
        .section { padding: 96px 6%; }
        .section-eyebrow { font-size: 12px; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--teal-600, var(--teal-500)); margin-bottom: 10px; }
        .section-h2 { font-family: 'Syne', sans-serif; font-size: clamp(28px, 3.5vw, 42px); font-weight: 800; letter-spacing: -0.025em; color: var(--neutral-900); line-height: 1.15; }
        .section-h2 em { font-style: normal; color: var(--teal-500); }

        .how-wrap { margin-top: 56px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1px; background: var(--neutral-100); border-radius: 16px; overflow: hidden; border: 1px solid var(--neutral-100); }
        .how-card { background: var(--white); padding: 36px 32px; transition: background 0.2s; }
        .how-card:hover { background: var(--teal-50); }
        .step-num { font-family: 'Syne', sans-serif; font-size: 12px; font-weight: 700; color: var(--teal-500); letter-spacing: 0.1em; margin-bottom: 20px; }
        .how-icon-wrap { width: 44px; height: 44px; border-radius: 10px; background: var(--teal-50); display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 20px; color: var(--teal-500); border: 1px solid rgba(13,148,136,0.15); }
        .how-title { font-size: 16px; font-weight: 600; color: var(--neutral-900); margin-bottom: 8px; }
        .how-desc { font-size: 13.5px; line-height: 1.7; color: var(--neutral-600); }

        /* ── FEATURES ── */
        .features-section { background: var(--neutral-900); padding: 96px 6%; }
        .features-section .section-eyebrow { color: var(--teal-400); }
        .features-section .section-h2 { color: var(--white); }
        .features-section .section-h2 em { color: var(--teal-400); }

        .feat-grid { margin-top: 56px; display: grid; grid-template-columns: repeat(12, 1fr); gap: 12px; }
        .feat-card {
            background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);
            border-radius: 14px; padding: 28px;
            transition: background 0.2s, border-color 0.2s;
        }
        .feat-card:hover { background: rgba(13,148,136,0.08); border-color: rgba(45,212,191,0.2); }
        .feat-card.c8  { grid-column: span 8; }
        .feat-card.c4  { grid-column: span 4; }
        .feat-card.c6  { grid-column: span 6; }
        .feat-icon { width: 40px; height: 40px; border-radius: 10px; background: rgba(45,212,191,0.1); display: flex; align-items: center; justify-content: center; color: var(--teal-400); font-size: 18px; margin-bottom: 18px; }
        .feat-title { font-size: 15px; font-weight: 600; color: var(--white); margin-bottom: 7px; }
        .feat-desc { font-size: 13px; line-height: 1.7; color: rgba(255,255,255,0.45); }
        .feat-tag { display: inline-block; margin-top: 14px; font-size: 11px; font-weight: 600; color: var(--teal-400); background: rgba(45,212,191,0.1); padding: 3px 9px; border-radius: 5px; }

        /* big feature */
        .feat-card.c8 { display: flex; align-items: flex-start; gap: 32px; }
        .feat-card.c8 .feat-icon { width: 52px; height: 52px; font-size: 24px; flex-shrink: 0; margin-bottom: 0; }
        .feat-card.c8 .feat-body { flex: 1; }

        /* ── STATS STRIP ── */
        .stats-strip { background: var(--teal-50); border-top: 1px solid rgba(13,148,136,0.1); border-bottom: 1px solid rgba(13,148,136,0.1); }
        .stats-inner { display: flex; max-width: 100%; padding: 0 6%; }
        .stat-block { flex: 1; padding: 48px 0; text-align: center; border-right: 1px solid rgba(13,148,136,0.1); }
        .stat-block:last-child { border-right: none; }
        .stat-num { font-family: 'Syne', sans-serif; font-size: 44px; font-weight: 800; color: var(--neutral-900); letter-spacing: -0.03em; line-height: 1; }
        .stat-num sup { font-size: 24px; }
        .stat-num em { color: var(--teal-500); font-style: normal; }
        .stat-label { font-size: 13px; color: var(--neutral-600); margin-top: 6px; }

        /* ── TESTIMONIALS ── */
        .testi-grid { margin-top: 56px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .testi-card { background: var(--neutral-50); border: 1px solid var(--neutral-100); border-radius: 14px; padding: 28px; }
        .testi-stars { display: flex; gap: 3px; color: var(--teal-500); font-size: 13px; margin-bottom: 14px; }
        .testi-text { font-size: 14px; line-height: 1.75; color: var(--neutral-600); }
        .testi-author { margin-top: 20px; display: flex; align-items: center; gap: 10px; }
        .testi-ava { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #fff; flex-shrink: 0; }
        .testi-name { font-size: 13px; font-weight: 600; color: var(--neutral-900); }
        .testi-role { font-size: 11.5px; color: var(--neutral-600); }

        /* ── CTA ── */
        .cta-section {
            padding: 96px 6%; background: var(--neutral-900); text-align: center;
        }
        .cta-h2 { font-family: 'Syne', sans-serif; font-size: clamp(28px, 4vw, 48px); font-weight: 800; color: var(--white); letter-spacing: -0.025em; line-height: 1.15; }
        .cta-h2 em { font-style: normal; color: var(--teal-400); }
        .cta-sub { font-size: 15px; color: rgba(255,255,255,0.45); margin-top: 14px; }
        .cta-btns { margin-top: 36px; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .btn-cta-main { display: inline-flex; align-items: center; gap: 8px; background: var(--teal-500); color: #fff; font-size: 14px; font-weight: 600; padding: 13px 28px; border-radius: 10px; text-decoration: none; transition: all 0.15s; }
        .btn-cta-main:hover { background: var(--teal-400); color: var(--neutral-900); transform: translateY(-1px); }
        .btn-cta-ghost { display: inline-flex; align-items: center; gap: 8px; border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.6); font-size: 14px; font-weight: 500; padding: 13px 24px; border-radius: 10px; text-decoration: none; transition: all 0.15s; }
        .btn-cta-ghost:hover { border-color: rgba(255,255,255,0.4); color: #fff; }

        /* ── FOOTER ── */
        footer { background: var(--neutral-900); border-top: 1px solid rgba(255,255,255,0.06); padding: 40px 6%; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; }
        .footer-logo { font-family: 'Syne', sans-serif; font-size: 17px; font-weight: 800; color: var(--white); display: flex; align-items: center; gap: 9px; }
        .footer-logo .logo-mark { width: 28px; height: 28px; border-radius: 7px; background: var(--teal-500); }
        .footer-links { display: flex; gap: 28px; }
        .footer-links a { font-size: 13px; color: rgba(255,255,255,0.35); text-decoration: none; transition: color 0.15s; }
        .footer-links a:hover { color: rgba(255,255,255,0.7); }
        .footer-copy { width: 100%; text-align: center; font-size: 12px; color: rgba(255,255,255,0.2); padding-top: 28px; border-top: 1px solid rgba(255,255,255,0.06); }

        /* ── REVEAL ── */
        .reveal { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .reveal.in { opacity: 1; transform: none; }
        .d1 { transition-delay: 0.08s; }
        .d2 { transition-delay: 0.16s; }
        .d3 { transition-delay: 0.24s; }

        @@media (max-width: 900px) {
            .hero-visual { display: none; }
            .how-wrap { grid-template-columns: 1fr; }
            .feat-grid { grid-template-columns: 1fr; }
            .feat-card.c8, .feat-card.c4, .feat-card.c6 { grid-column: span 1; }
            .feat-card.c8 { flex-direction: column; }
            .testi-grid { grid-template-columns: 1fr; }
            .stats-inner { flex-wrap: wrap; }
            .stat-block { flex: 1 1 50%; border-bottom: 1px solid rgba(13,148,136,0.1); }
            .nav-links { display: none; }
            .hero-bottom { flex-wrap: wrap; gap: 20px; }
        }

        @@media (prefers-reduced-motion: reduce) {
            .reveal { opacity: 1 !important; transform: none !important; }
        }

        /* ── AUTH MODAL (login & register tanpa pindah halaman) ── */
        .auth-modal-overlay {
            display: none; position: fixed; inset: 0; z-index: 200;
            background: rgba(2,26,24,0.55); backdrop-filter: blur(3px);
            align-items: center; justify-content: center; padding: 20px;
        }
        .auth-modal-overlay.open { display: flex; }
        .auth-modal-box {
            background: var(--white); border-radius: 18px; padding: 34px 32px;
            max-width: 420px; width: 100%; max-height: 92vh; overflow-y: auto;
            box-shadow: 0 20px 60px rgba(2,26,24,0.3);
            position: relative; animation: authPop 0.2s ease;
        }
        @@keyframes authPop { from { opacity: 0; transform: translateY(10px) scale(0.98); } to { opacity: 1; transform: none; } }
        .auth-modal-close {
            position: absolute; top: 16px; right: 16px; width: 32px; height: 32px;
            border-radius: 50%; border: none; background: var(--neutral-100); color: var(--neutral-600);
            display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 16px;
            transition: background 0.15s;
        }
        .auth-modal-close:hover { background: var(--neutral-300); }
        .auth-modal-logo { display: flex; align-items: center; gap: 8px; font-family:'Syne',sans-serif; font-weight: 800; font-size: 20px; color: var(--neutral-900); margin-bottom: 4px; justify-content: center; }
        .auth-modal-logo i { color: var(--teal-500); font-size: 24px; }
        .auth-modal-sub { text-align: center; font-size: 13px; color: var(--neutral-600); margin-bottom: 22px; }
        .auth-form-group { margin-bottom: 14px; }
        .auth-form-group label { display: block; font-size: 12.5px; font-weight: 600; color: var(--neutral-900); margin-bottom: 6px; }
        .auth-form-group input {
            width: 100%; padding: 10px 13px; border: 1.5px solid var(--neutral-300); border-radius: 9px;
            font-size: 13.5px; font-family: inherit; color: var(--neutral-900); background: var(--white);
        }
        .auth-form-group input:focus { outline: none; border-color: var(--teal-500); }
        .auth-modal-submit {
            width: 100%; justify-content: center; border: none; cursor: pointer;
            margin-top: 6px; font-family: inherit;
        }
        .auth-modal-switch { text-align: center; font-size: 13px; color: var(--neutral-600); margin-top: 16px; }
        .auth-modal-switch a, .auth-modal-switch button.linklike {
            color: var(--teal-500); font-weight: 600; text-decoration: none; background: none; border: none;
            cursor: pointer; font-size: 13px; font-family: inherit; padding: 0;
        }
        .auth-modal-alert {
            font-size: 12.5px; padding: 10px 13px; border-radius: 9px; margin-bottom: 14px;
            display: none; align-items: center; gap: 7px;
        }
        .auth-modal-alert.show { display: flex; }
        .auth-modal-alert.error { background: #fef2f2; color: #dc2626; }
        .auth-modal-alert.success { background: var(--teal-50); color: var(--teal-700); }
    </style>
</head>
<body>

<!-- NAV -->
<nav>
   <div class="auth-modal-logo"><i class="ti ti-leaf" aria-hidden="true"></i> SmaCan</div>
    <div class="nav-links">
        <a href="#">Beranda</a>
        <a href="#cara-kerja">Cara Kerja</a>
        <a href="#fitur">Fitur</a>
        <a href="#dampak">Dampak</a>
    </div>
    <div class="nav-actions">
        <a class="btn-ghost" href="javascript:void(0)" onclick="openAuthModal('login')">Masuk</a>
        <a class="btn-primary" href="javascript:void(0)" onclick="openAuthModal('register')">Daftar Gratis</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <h1 class="hero-h1">Mari Jagalah Kebersihan</span></h1>
        <p class="hero-p">Sampah pintar yang membantu menjaga lingkungan sekolahmu tetap bersih dan nyaman.</p>
        <div class="hero-btns">
            <a class="btn-hero btn-hero-main" href="javascript:void(0)" onclick="openAuthModal('register')"><i class="ti ti-leaf"></i> Mulai Sekarang</a>
        </div>
    </div>

    <!-- Right visual: stacked cards -->
    <div class="hero-visual">
        <div class="hero-card-stack" style="padding-top:26px">
            <div class="hcard-behind-2"></div>
            <div class="hcard-behind-1"></div>
            <div class="hcard hcard-main">
                <div class="hcard-header">
                    <span class="hcard-title">Status Tong Sampah</span>
                    <span class="hcard-dot"></span>
                </div>
                <div class="tong-row">
                    <div class="tong-icon" style="background:#f0fdf4;color:#16a34a"><i class="ti ti-trash"></i></div>
                    <div class="tong-info">
                        <div class="tong-name">Tong A Depan Lab</div>
                        <div class="tong-loc">Gedung Sains, Lt. 1</div>
                    </div>
                    <span class="tong-status status-ok">Kosong</span>
                </div>
                <div class="tong-row">
                    <div class="tong-icon" style="background:#fffbeb;color:#d97706"><i class="ti ti-trash"></i></div>
                    <div class="tong-info">
                        <div class="tong-name">Tong B Kantin</div>
                        <div class="tong-loc">Area Makan, Lt. 1</div>
                    </div>
                    <span class="tong-status status-mid">Sedang</span>
                </div>
                <div class="tong-row">
                    <div class="tong-icon" style="background:#fef2f2;color:#dc2626"><i class="ti ti-trash"></i></div>
                    <div class="tong-info">
                        <div class="tong-name">Tong C Koridor</div>
                        <div class="tong-loc">Gedung Utama, Lt. 2</div>
                    </div>
                    <span class="tong-status status-bad">Penuh</span>
                </div>
                <div class="hcard-footer">
                    <span class="hcard-footer-label">Diperbarui 2 menit lalu</span>
                    <span class="poin-chip">+50 poin dari laporanmu</span>
                </div>
            </div>
            <!-- floating badge -->
            <div class="float-badge">
                <div class="float-badge-icon"><i class="ti ti-trophy"></i></div>
                <div class="float-badge-text">
                    <div class="float-badge-num">#1 Leaderboard</div>
                    <div class="float-badge-sub">Kamu di posisi teratas!</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom stat bar -->
    <div class="hero-bottom">
        <div class="hero-stat-item">
            <div class="hero-stat-num">12<span>+</span></div>
            <div class="hero-stat-label">Tong terpantau</div>
        </div>
        <div class="hero-stat-item">
            <div class="hero-stat-num">3<span>×</span></div>
            <div class="hero-stat-label">Lebih cepat ditangani</div>
        </div>
        <div class="hero-stat-item">
            <div class="hero-stat-num">98<span>%</span></div>
            <div class="hero-stat-label">Laporan direspons</div>
        </div>
        <div class="hero-stat-item">
            <div class="hero-stat-num">100<span>%</span></div>
            <div class="hero-stat-label">Berbasis web</div>
        </div>
    </div>
</section>

<!-- HOW -->
<section class="section" id="cara-kerja">
    <p class="section-eyebrow reveal">Cara kerja</p>
    <h2 class="section-h2 reveal d1">Tiga langkah<br>jaga <em>lingkungan</em></h2>
    <div class="how-wrap">
        <div class="how-card reveal">
            <p class="step-num">LANGKAH 01</p>
            <div class="how-icon-wrap"><i class="ti ti-map-pin"></i></div>
            <div class="how-title">Pantau Lokasi Tong</div>
            <div class="how-desc">Lihat status setiap tong sampah di sekolah secara real-time — kosong, sedang, atau penuh — langsung dari browser.</div>
        </div>
        <div class="how-card reveal d1">
            <p class="step-num">LANGKAH 02</p>
            <div class="how-icon-wrap"><i class="ti ti-upload"></i></div>
            <div class="how-title">Laporkan Kondisi</div>
            <div class="how-desc">Foto, pilih tong, kirim laporan dalam hitungan detik. Petugas langsung tahu di mana harus bertindak.</div>
        </div>
        <div class="how-card reveal d2">
            <p class="step-num">LANGKAH 03</p>
            <div class="how-icon-wrap"><i class="ti ti-star"></i></div>
            <div class="how-title">Kumpulkan Poin</div>
            <div class="how-desc">Setiap laporan dan artikel edukasi yang diselesaikan menambah poin. Naik level, masuk leaderboard.</div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features-section" id="fitur">
    <p class="section-eyebrow reveal">Fitur Smacan</p>
    <h2 class="section-h2 reveal d1">Dibangun untuk<br><em>Menjaga Lingkungan</em></h2>
    <div class="feat-grid">
        <div class="feat-card c8 reveal">
            <div class="feat-icon"><i class="ti ti-map-2"></i></div>
            <div class="feat-body">
                <div class="feat-title">Peta Tong Real-time</div>
                <div class="feat-desc">Semua tong sampah di sekolah terpetakan secara digital. Status diperbarui setiap kali laporan masuk — kamu tahu mana yang butuh perhatian sekarang.</div>
                <span class="feat-tag">Live Update</span>
            </div>
        </div>
        <div class="feat-card c4 reveal d1">
            <div class="feat-icon"><i class="ti ti-trophy"></i></div>
            <div class="feat-title">Leaderboard</div>
            <div class="feat-desc">Papan skor real-time. Siapa yang paling peduli dengan sekolah?</div>
            <span class="feat-tag">Kompetitif</span>
        </div>
        <div class="feat-card c6 reveal">
            <div class="feat-icon"><i class="ti ti-book-2"></i></div>
            <div class="feat-title">Edukasi Lingkungan</div>
            <div class="feat-desc">Artikel pilihan tentang daur ulang dan keberlanjutan. Baca tuntas, klaim poin langsung.</div>
            <span class="feat-tag">+Poin</span>
        </div>
        <div class="feat-card c6 reveal d1">
            <div class="feat-icon"><i class="ti ti-camera"></i></div>
            <div class="feat-title">Laporan Foto</div>
            <div class="feat-desc">Upload bukti kondisi tong langsung dari HP. Mudah, cepat, dan terdata dengan baik.</div>
            <span class="feat-tag">Mobile Ready</span>
        </div>
    </div>
</section>

<!-- STATS -->
<div class="stats-strip" id="dampak">
    <div class="stats-inner">
        <div class="stat-block reveal">
            <div class="stat-num">98<sup>%</sup></div>
            <div class="stat-label">Laporan direspons dalam 30 menit</div>
        </div>
        <div class="stat-block reveal d1">
            <div class="stat-num">4.8<em>/5</em></div>
            <div class="stat-label">Rating kepuasan pengguna</div>
        </div>
        <div class="stat-block reveal d2">
            <div class="stat-num">2<em>×</em></div>
            <div class="stat-label">Lebih sedikit tong meluap</div>
        </div>
        <div class="stat-block reveal d3">
            <div class="stat-num">100<sup>%</sup></div>
            <div class="stat-label">Berbasis web, tanpa install app</div>
        </div>
    </div>
</div>

<!-- TESTIMONIALS -->
<section class="section">
    <p class="section-eyebrow reveal"> Apa Kata mereka</p>
    <h2 class="section-h2 reveal d1">Ulasan<br><em>Siswa/Siswi</em></h2>
    <div class="testi-grid">
        <div class="testi-card reveal">
            <div class="testi-stars">★★★★★</div>
            <div class="testi-text">SmaCan bikin aku sadar bahwa hal kecil kayak laporan tong sampah bisa kasih dampak besar ke sekolah. Plus poinnya bikin nagih!</div>
            <div class="testi-author">
                <div class="testi-ava" style="background:#0d9488">AR</div>
                <div><div class="testi-name">Arya R.</div><div class="testi-role">Kelas XI IPA</div></div>
            </div>
        </div>
        <div class="testi-card reveal d1">
            <div class="testi-stars">★★★★★</div>
            <div class="testi-text">Sekarang kalau lihat tong sampah penuh, langsung lapor aja. Gampang banget dan ternyata udah banyak temen yang lakuin hal yang sama.</div>
            <div class="testi-author">
                <div class="testi-ava" style="background:#0a6b60">DS</div>
                <div><div class="testi-name">Dea S.</div><div class="testi-role">Kelas X IPS</div></div>
            </div>
        </div>
        <div class="testi-card reveal d2">
            <div class="testi-stars">★★★★★</div>
            <div class="testi-text">Akhirnya ada cara yang asik buat peduli sama lingkungan sekolah. Leaderboard-nya bikin aku semangat ngalahin teman-teman.</div>
            <div class="testi-author">
                <div class="testi-ava" style="background:#2dd4bf;color:#021a18">FN</div>
                <div><div class="testi-name">Fadhil N.</div><div class="testi-role">Kelas XII IPA</div></div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <h2 class="cta-h2 reveal">Siap jadi pahlawan<br>kebersihan <em>sekolah?</em></h2>
    <p class="cta-sub reveal d1">Daftar sekarang.</p>
    <div class="cta-btns reveal d2">
        <a class="btn-cta-main" href="javascript:void(0)" onclick="openAuthModal('register')"><i class="ti ti-leaf"></i>Buat Akun</a>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-logo">
        SmaCan
    </div>
    <div class="footer-links">
        <a href="#cara-kerja">Beranda</a>
        <a href="#cara-kerja">Cara Kerja</a>
        <a href="#fitur">Fitur</a>
        <a href="{{ url('/login') }}">Masuk</a>
        <a href="{{ url('/register') }}">Daftar</a>
    </div>
    <div class="footer-copy">© {!! date('Y') !!} SmaCan Jaga Sekolah, Jaga Bumi.</div>
</footer>

<!-- AUTH MODAL: Login & Register tetap di landing page, alamat URL tidak berubah -->
<div class="auth-modal-overlay" id="authModalOverlay">
    <div class="auth-modal-box">
        <button type="button" class="auth-modal-close" onclick="closeAuthModal()" aria-label="Tutup">
            <i class="ti ti-x" aria-hidden="true"></i>
        </button>

        <!-- LOGIN FORM -->
        <div id="authPaneLogin">
            <div class="auth-modal-logo"><i class="ti ti-leaf" aria-hidden="true"></i> SmaCan</div>
            <p class="auth-modal-sub">Masuk</p>
            <div class="auth-modal-alert" id="loginAlert"></div>
            <form id="loginForm" onsubmit="return submitAuthForm(event, 'login')">
                <div class="auth-form-group">
                    <label for="loginEmail">Email</label>
                    <input type="email" id="loginEmail" name="email" placeholder="@@email.com" required autocomplete="email">
                </div>
                <div class="auth-form-group">
                    <label for="loginPassword">Password</label>
                    <input type="password" id="loginPassword" name="password" placeholder="Masukkan password" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn-primary auth-modal-submit">
                    <i class="ti ti-login" aria-hidden="true"></i> Masuk
                </button>
            </form>
            <div class="auth-modal-switch">
                Belum punya akun? <button type="button" class="linklike" onclick="openAuthModal('register')">Daftar di sini</button>
            </div>
        </div>

        <!-- REGISTER FORM -->
        <div id="authPaneRegister" style="display:none">
            <div class="auth-modal-logo"><i class="ti ti-leaf" aria-hidden="true"></i> SmaCan</div>
            <p class="auth-modal-sub">Buat akun baru</p>
            <div class="auth-modal-alert" id="registerAlert"></div>
            <form id="registerForm" onsubmit="return submitAuthForm(event, 'register')">
                <div class="auth-form-group">
                    <label for="regNama">Nama Lengkap</label>
                    <input type="text" id="regNama" name="nama" placeholder="Nama lengkap" required autocomplete="name">
                </div>
                <div class="auth-form-group">
                    <label for="regEmail">Email</label>
                    <input type="email" id="regEmail" name="email" placeholder="@@email.com" required autocomplete="email">
                </div>
                <div class="auth-form-group">
                    <label for="regNis">NIS (opsional)</label>
                    <input type="text" id="regNis" name="nis" placeholder="Nomor Induk Siswa">
                </div>
                <div class="auth-form-group">
                    <label for="regKelas">Kelas (opsional)</label>
                    <input type="text" id="regKelas" name="kelas" placeholder="Contoh: 11 IPA 2">
                </div>
                <div class="auth-form-group">
                    <label for="regPassword">Password</label>
                    <input type="password" id="regPassword" name="password" placeholder="Minimal 6 karakter" required autocomplete="new-password">
                </div>
                <div class="auth-form-group">
                    <label for="regPasswordConfirm">Konfirmasi Password</label>
                    <input type="password" id="regPasswordConfirm" name="password_confirm" placeholder="Ulangi password" required autocomplete="new-password">
                </div>
                <button type="submit" class="btn-primary auth-modal-submit">
                    <i class="ti ti-user-plus" aria-hidden="true"></i> Daftar
                </button>
            </form>
            <div class="auth-modal-switch">
                Sudah punya akun? <button type="button" class="linklike" onclick="openAuthModal('login')">Masuk di sini</button>
            </div>
        </div>
    </div>
</div>

<script>
const APP_URL_LANDING = '{{ url("/") }}';

function openAuthModal(type) {
    document.getElementById('authModalOverlay').classList.add('open');
    document.getElementById('authPaneLogin').style.display = type === 'login' ? 'block' : 'none';
    document.getElementById('authPaneRegister').style.display = type === 'register' ? 'block' : 'none';
    document.body.style.overflow = 'hidden';
}
function closeAuthModal() {
    document.getElementById('authModalOverlay').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('authModalOverlay').addEventListener('click', (e) => {
    if (e.target.id === 'authModalOverlay') closeAuthModal();
});
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeAuthModal();
});

function showAuthAlert(elId, message, isError) {
    const el = document.getElementById(elId);
    el.textContent = message;
    el.classList.remove('error', 'success');
    el.classList.add(isError ? 'error' : 'success', 'show');
}

function submitAuthForm(event, type) {
    event.preventDefault();
    const form = type === 'login' ? document.getElementById('loginForm') : document.getElementById('registerForm');
    const alertId = type === 'login' ? 'loginAlert' : 'registerAlert';
    const btn = form.querySelector('button[type="submit"]');
    const originalLabel = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="ti ti-loader-2" aria-hidden="true"></i> Memproses...';

    fetch(`${APP_URL_LANDING}/${type}`, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: new FormData(form),
    })
        .then((res) => res.json())
        .then((res) => {
            if (res.success) {
                showAuthAlert(alertId, res.message, false);
                setTimeout(() => { window.location.href = res.redirect; }, 600);
            } else {
                showAuthAlert(alertId, res.message, true);
                btn.disabled = false;
                btn.innerHTML = originalLabel;
            }
        })
        .catch(() => {
            showAuthAlert(alertId, 'Terjadi kesalahan jaringan. Coba lagi.', true);
            btn.disabled = false;
            btn.innerHTML = originalLabel;
        });

    return false;
}

const obs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); obs.unobserve(e.target); } });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
</script>
</body>
</html>
