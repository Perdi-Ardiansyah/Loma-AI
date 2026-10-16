<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loma.AI - Platform Pembelajaran Interaktif & Gamifikasi Berbasis AI</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Ubah dokumen apapun menjadi modul belajar seru dengan Rangkuman AI, Kuis 15 Tantangan EXP, 3D Flashcards, dan Peta Konsep otomatis.">
    <meta name="keywords" content="gamifikasi edukasi, ai belajar, active recall, flashcards, kuis interaktif, loma ai">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        /* Smooth Page Transition */
        body {
            opacity: 0;
            transform: translateY(4px);
            transition: opacity 0.28s cubic-bezier(0.16, 1, 0.3, 1), transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        }
        body.page-loaded {
            opacity: 1;
            transform: translateY(0);
        }
        body.page-leaving {
            opacity: 0;
            transform: translateY(-4px);
            transition: opacity 0.2s ease-in, transform 0.2s ease-in;
        }

        /* Parallax & Scroll Reveal */
        .parallax-item {
            will-change: transform;
            transition: transform 0.12s cubic-bezier(0, 0, 0.2, 1);
        }

        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-on-scroll.is-revealed {
            opacity: 1;
            transform: translateY(0);
        }

        .card-glass {
            background: #ffffff;
        }
        .pulse-slow {
            animation: pulseSlow 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulseSlow {
            0%, 100% { opacity: 0.8; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.02); }
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 selection:bg-indigo-500 selection:text-white relative overflow-x-hidden">

    <!-- Top Loading / Transition Bar -->
    <div id="pageTransitionBar" class="fixed top-0 left-0 w-0 h-1 bg-indigo-600 z-[99999] transition-all duration-300 pointer-events-none"></div>

    <!-- Top Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-white/85 backdrop-blur-md border-b border-slate-200/80 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <!-- Brand Logo -->
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5 group">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform">
                    <i class="ph-bold ph-graduation-cap text-xl"></i>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="font-extrabold text-slate-900 tracking-tight text-lg">Loma<span class="text-indigo-600">.AI</span></span>
                        <span class="bg-indigo-100 text-indigo-700 text-[10px] font-black px-1.5 py-0.2 rounded-full uppercase tracking-wider">EXP</span>
                    </div>
                    <p class="text-[10px] text-slate-500 font-medium -mt-0.5">Gamified Learning Platform</p>
                </div>
            </a>

            <!-- Nav Links (Desktop) -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#fitur" class="text-xs font-bold text-slate-600 hover:text-indigo-600 transition-colors">Fitur Unggulan</a>
                <a href="#cara-kerja" class="text-xs font-bold text-slate-600 hover:text-indigo-600 transition-colors">Cara Kerja</a>
                <a href="#gamifikasi" class="text-xs font-bold text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-1">
                    <span>Sistem EXP</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                </a>
                <a href="#preview" class="text-xs font-bold text-slate-600 hover:text-indigo-600 transition-colors">Demo Studio</a>
                <a href="#faq" class="text-xs font-bold text-slate-600 hover:text-indigo-600 transition-colors">FAQ</a>
            </div>

            <!-- Right CTA Buttons -->
            <div class="flex items-center gap-2 sm:gap-3">
                @if(Auth::check())
                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800">
                    <span class="w-5 h-5 rounded-full {{ strtolower(Auth::user()->name) === 'guest' || Auth::user()->role === 'Guest' ? 'bg-amber-500' : 'bg-indigo-600' }} text-white flex items-center justify-center text-[10px] font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    <span class="max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                    @if(strtolower(Auth::user()->name) === 'guest' || Auth::user()->role === 'Guest')
                    <span class="bg-amber-100 text-amber-900 border border-amber-300 text-[9px] font-black px-1.5 py-0.2 rounded uppercase">Guest</span>
                    @endif
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0">
                    @csrf
                    <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all" title="Keluar / Logout">
                        <i class="ph-bold ph-sign-out text-base"></i>
                    </button>
                </form>
                <a href="{{ route('app') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-sm transition-all hover:scale-105 flex items-center gap-1.5">
                    <span>Ke Studio</span>
                    <i class="ph-bold ph-arrow-right"></i>
                </a>
                @else
                <a href="{{ route('login') }}" class="px-3.5 py-2 text-xs font-bold text-slate-700 hover:text-indigo-600 rounded-xl hover:bg-slate-100/80 transition-all flex items-center gap-1.5">
                    <i class="ph-bold ph-sign-in"></i>
                    <span>Masuk</span>
                </a>
                <a href="{{ route('demo.login') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-300 rounded-xl text-xs font-extrabold shadow-xs transition-all hover:scale-105" title="Masuk langsung tanpa akun">
                    <i class="ph-bold ph-user text-amber-600"></i>
                    <span>Guest</span>
                </a>
                @endif
            </div>

        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="relative pt-12 pb-20 sm:pt-20 sm:pb-28 overflow-hidden bg-slate-50">
        <!-- Parallax Background Decorative Rings -->
        <div class="parallax-item pointer-events-none absolute left-8 top-20 w-44 h-44 rounded-full border border-indigo-200/50 hidden md:block select-none" data-speed="0.12"></div>
        <div class="parallax-item pointer-events-none absolute right-10 top-40 w-60 h-60 rounded-full border border-amber-200/40 hidden md:block select-none" data-speed="-0.16"></div>
        <div class="parallax-item pointer-events-none absolute left-1/3 -bottom-8 w-32 h-32 rounded-full border border-emerald-200/50 hidden lg:block select-none" data-speed="0.2"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Floating Parallax Badge Left -->
            <div class="parallax-item hidden lg:flex absolute left-2 xl:left-8 top-24 z-20 items-center gap-2.5 bg-white border border-indigo-200 px-3.5 py-2 rounded-2xl shadow-md select-none hover:shadow-lg transition-shadow" data-speed="0.22">
                <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm shadow-xs">
                    <i class="ph-fill ph-trophy"></i>
                </div>
                <div>
                    <div class="text-[11px] font-extrabold text-slate-900">+20 EXP / Soal</div>
                    <div class="text-[10px] text-slate-500 font-medium">Kuis 15 Tantangan</div>
                </div>
            </div>

            <!-- Floating Parallax Badge Right -->
            <div class="parallax-item hidden lg:flex absolute right-2 xl:right-8 top-32 z-20 items-center gap-2.5 bg-white border border-emerald-200 px-3.5 py-2 rounded-2xl shadow-md select-none hover:shadow-lg transition-shadow" data-speed="-0.26">
                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-sm shadow-xs">
                    <i class="ph-fill ph-cards"></i>
                </div>
                <div>
                    <div class="text-[11px] font-extrabold text-slate-900">Active Recall 3D</div>
                    <div class="text-[10px] text-slate-500 font-medium">Retensi Memori 3x</div>
                </div>
            </div>

            <div class="text-center max-w-3xl mx-auto space-y-6">
                <!-- Eyebrow Pill Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-indigo-100 shadow-sm text-indigo-700 text-xs font-bold">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                    </span>
                    <span>Platform Pembelajaran Gamifikasi & AI Pintar</span>
                    <span class="bg-indigo-50 text-indigo-700 text-[10px] font-black px-1.5 py-0.2 rounded-full border border-indigo-200">v2.0</span>
                </div>

                <!-- Main Hero Headline -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Ubah Dokumen Apapun Menjadi Petualangan Belajar <span class="text-indigo-600">Interaktif & Menyenangkan</span>
                </h1>

                <!-- Subtitle -->
                <p class="text-sm sm:text-base lg:text-lg text-slate-600 font-normal leading-relaxed max-w-2xl mx-auto">
                    Kuasai materi pelajaran dan kuliah lebih cepat dengan rangkuman cerdas AI, <strong>Kuis 15 Tantangan EXP</strong>, <strong>Flashcard 3D Active Recall</strong>, serta <strong>Peta Konsep Pop-Up</strong> yang terbukti meningkatkan retensi memori hingga 3x lipat.
                </p>

                <!-- Action CTAs -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('app') }}" class="w-full sm:w-auto px-7 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-sm font-extrabold shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all hover:scale-105 flex items-center justify-center gap-2">
                        <i class="ph-bold ph-rocket-launch text-lg"></i>
                        <span>Mulai Belajar Sekarang (Gratis)</span>
                    </a>
                    <a href="{{ route('demo.login') }}" class="w-full sm:w-auto px-6 py-3.5 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 text-slate-700 rounded-2xl text-sm font-bold shadow-xs transition-all flex items-center justify-center gap-2">
                        <i class="ph-bold ph-user-circle text-amber-600 text-lg"></i>
                        <span>Mode Guest (+100 EXP)</span>
                    </a>
                </div>

                <!-- Trust Micro-Badges -->
                <div class="pt-4 flex flex-wrap items-center justify-center gap-5 text-xs text-slate-500 font-medium">
                    <div class="flex items-center gap-1.5">
                        <i class="ph-fill ph-check-circle text-emerald-500 text-base"></i>
                        <span>Minimal 15 Soal Kuis Komprehensif</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="ph-fill ph-check-circle text-emerald-500 text-base"></i>
                        <span>Flashcard 3D Active Recall</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="ph-fill ph-check-circle text-emerald-500 text-base"></i>
                        <span>Peta Konsep & Hierarki Pop-Up</span>
                    </div>
                </div>
            </div>

            <!-- INTERACTIVE STUDIO PREVIEW SHOWCASE (WITH PARALLAX) -->
            <div id="preview" class="mt-14 max-w-5xl mx-auto relative parallax-item" data-speed="0.05">
                <!-- Parallax Floating Chips Around Studio Mockup -->
                <div class="parallax-item hidden xl:flex absolute -left-8 top-1/3 -translate-y-1/2 z-20 items-center gap-2 bg-slate-900 text-white px-3.5 py-2 rounded-xl shadow-lg border border-slate-700 select-none" data-speed="0.14">
                    <i class="ph-fill ph-fire text-amber-400 text-base"></i>
                    <span class="text-xs font-bold">Streak 5 Hari 🔥</span>
                </div>
                <div class="parallax-item hidden xl:flex absolute -right-8 top-1/2 -translate-y-1/2 z-20 items-center gap-2 bg-indigo-700 text-white px-3.5 py-2 rounded-xl shadow-lg border border-indigo-600 select-none" data-speed="-0.15">
                    <i class="ph-fill ph-check-circle text-emerald-400 text-base"></i>
                    <span class="text-xs font-bold">Peta Konsep Aktif 🌳</span>
                </div>

                <div class="bg-indigo-50/70 p-2 sm:p-3 rounded-3xl shadow-lg border border-indigo-200">
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-lg">
                        
                        <!-- Mockup Topbar -->
                        <div class="bg-slate-900 text-white px-4 py-3 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                <span class="text-xs font-bold text-slate-300 ml-2">Loma.AI Studio Preview</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="bg-amber-400/20 text-amber-300 border border-amber-400/30 text-[10px] font-extrabold px-2 py-0.5 rounded-full flex items-center gap-1">
                                    <i class="ph-fill ph-fire text-amber-400"></i> Streak 3 Hari
                                </span>
                                <span class="bg-indigo-500/30 text-indigo-200 border border-indigo-400/30 text-[10px] font-extrabold px-2 py-0.5 rounded-full">
                                    ⭐ Level 3 Cendekia
                                </span>
                            </div>
                        </div>

                        <!-- Interactive Tab Bar on Mockup -->
                        <div class="bg-slate-50 border-b border-slate-200 px-4 py-2.5 flex flex-wrap items-center justify-between gap-2">
                            <div class="flex items-center gap-1.5 bg-white p-1 rounded-xl border border-slate-200 shadow-2xs">
                                <button onclick="switchPreviewTab('rangkuman')" id="pTab-rangkuman" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-indigo-600 text-white shadow-xs transition-all">
                                    📖 Rangkuman AI
                                </button>
                                <button onclick="switchPreviewTab('kuis')" id="pTab-kuis" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all">
                                    🏆 Kuis 15 Soal
                                </button>
                                <button onclick="switchPreviewTab('flashcard')" id="pTab-flashcard" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all">
                                    🃏 3D Flashcard
                                </button>
                                <button onclick="switchPreviewTab('peta')" id="pTab-peta" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all">
                                    🌳 Peta Konsep
                                </button>
                            </div>

                            <a href="{{ route('demo.login') }}" class="text-xs font-bold text-amber-700 hover:text-amber-900 flex items-center gap-1">
                                <span>Mode Guest</span>
                                <i class="ph-bold ph-user-circle"></i>
                            </a>
                        </div>

                        <!-- Mockup Dynamic Content Area -->
                        <div class="p-5 sm:p-7 min-h-[340px] bg-slate-50/50">
                            
                            <!-- TAB 1: RANGKUMAN -->
                            <div id="pContent-rangkuman" class="space-y-4">
                                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">Ekstraksi Dokumen AI</span>
                                        <span class="text-xs text-slate-400 font-medium">3 Sumber Dianalisis</span>
                                    </div>
                                    <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Transformasi Digital & Gamifikasi Pembelajaran</h3>
                                    <div class="p-3.5 bg-indigo-50/40 border border-indigo-100/80 rounded-xl text-xs sm:text-sm text-slate-700 leading-relaxed">
                                        <strong class="text-indigo-900 font-bold">Ringkasan Eksekutif:</strong> Gamifikasi menyelaraskan mekanisme motivasi kognitif dengan target capaian belajar melalui tantangan terukur, pengulangan terprogram (*spaced repetition*), dan umpan balik (*feedback loop*) seketika.
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-2">
                                        <div class="p-3 bg-white border border-slate-200 rounded-xl text-xs">
                                            <span class="font-extrabold text-indigo-600">1. Active Recall</span>
                                            <p class="text-slate-500 mt-1 text-[11px]">Uji ingatan aktif memicu koneksi neural yang lebih kokoh.</p>
                                        </div>
                                        <div class="p-3 bg-white border border-slate-200 rounded-xl text-xs">
                                            <span class="font-extrabold text-emerald-600">2. Spaced Repetition</span>
                                            <p class="text-slate-500 mt-1 text-[11px]">Interval teratur melawan kurva lupa Hermann Ebbinghaus.</p>
                                        </div>
                                        <div class="p-3 bg-white border border-slate-200 rounded-xl text-xs">
                                            <span class="font-extrabold text-amber-600">3. Reward & EXP</span>
                                            <p class="text-slate-500 mt-1 text-[11px]">Feedback gamifikasi mendorong kepuasan belajar konsisten.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 2: KUIS -->
                            <div id="pContent-kuis" class="hidden space-y-4">
                                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="bg-amber-100 text-amber-800 text-[10px] font-black px-2.5 py-0.5 rounded-full">KUIS 15 SOAL</span>
                                            <span class="text-xs font-bold text-slate-500">Soal 1 dari 15</span>
                                        </div>
                                        <span class="text-xs font-extrabold text-amber-600 flex items-center gap-1">
                                            <i class="ph-fill ph-trophy"></i> +20 EXP Tiap Benar
                                        </span>
                                    </div>
                                    <h4 class="text-sm sm:text-base font-bold text-slate-900">
                                        Mengapa metode Active Recall terbukti secara neurosains lebih efektif dibandingkan membaca ulang materi secara pasif?
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                                        <div class="p-3 bg-indigo-50 border border-indigo-600 rounded-xl font-bold text-indigo-950 flex items-center gap-2 shadow-2xs">
                                            <span class="w-6 h-6 rounded-md bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0">A</span>
                                            <span>Memicu rekonstruksi neural yang memperkuat jejak memori jangka panjang</span>
                                        </div>
                                        <div class="p-3 bg-white border border-slate-200 rounded-xl text-slate-700 flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs shrink-0">B</span>
                                            <span>Karena membaca pasif membutuhkan waktu lebih lama</span>
                                        </div>
                                        <div class="p-3 bg-white border border-slate-200 rounded-xl text-slate-700 flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs shrink-0">C</span>
                                            <span>Active Recall hanya cocok untuk hafalan rumus eksak</span>
                                        </div>
                                        <div class="p-3 bg-white border border-slate-200 rounded-xl text-slate-700 flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs shrink-0">D</span>
                                            <span>Mengurangi kapasitas otak dalam mengingat informasi baru</span>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-900 flex items-start gap-2">
                                        <i class="ph-bold ph-check-circle text-emerald-600 text-base mt-0.5"></i>
                                        <div>
                                            <span class="font-bold">Pembahasan Instan:</span> Menarik kembali ingatan secara mandiri memaksa otak membentuk kembali sinapsis (*neural pathway*), menghasilkan pemahaman permanen.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 3: FLASHCARD -->
                            <div id="pContent-flashcard" class="hidden space-y-4">
                                <div class="max-w-md mx-auto bg-indigo-700 text-white rounded-3xl p-6 sm:p-8 shadow-lg text-center space-y-4 relative overflow-hidden border border-indigo-600">
                                    <div class="flex items-center justify-between text-xs text-indigo-200 font-bold">
                                        <span>KARTU 1 DARI 8</span>
                                        <span class="bg-white/20 px-2 py-0.5 rounded-full text-[10px]">Tingkat: Penting</span>
                                    </div>
                                    <div class="py-6">
                                        <span class="text-xs uppercase tracking-wider text-indigo-200 font-extrabold block mb-2">Pertanyaan / Istilah:</span>
                                        <h3 class="text-lg sm:text-xl font-black tracking-tight leading-snug">
                                            Apa yang dimaksud dengan "Kurva Lupa" (Forgetting Curve) karya Hermann Ebbinghaus?
                                        </h3>
                                    </div>
                                    <div class="pt-2 flex items-center justify-center gap-3">
                                        <button class="px-4 py-2 bg-white text-indigo-700 rounded-xl text-xs font-bold shadow-md hover:bg-slate-50 transition-all flex items-center gap-1.5">
                                            <i class="ph-bold ph-arrows-clockwise"></i>
                                            <span>Balik Kartu (Spasi)</span>
                                        </button>
                                        <button class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold shadow-md transition-all flex items-center gap-1.5">
                                            <i class="ph-bold ph-check"></i>
                                            <span>Kuasai (+15 EXP)</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 4: PETA KONSEP -->
                            <div id="pContent-peta" class="hidden space-y-4">
                                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs space-y-3">
                                    <div class="text-center pb-2">
                                        <span class="text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">Topik Inti</span>
                                        <h4 class="text-base font-extrabold text-slate-900 mt-1">Sains Pembelajaran & Gamifikasi Modern</h4>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                        <div class="p-3.5 bg-indigo-50/70 border border-indigo-200 rounded-xl text-xs space-y-1">
                                            <span class="text-[9px] font-black uppercase text-indigo-700 bg-indigo-100 px-1.5 py-0.2 rounded">Cabang 1</span>
                                            <h5 class="font-bold text-indigo-950">Active Recall Engine</h5>
                                            <p class="text-slate-600 text-[11px]">Pengujian mandiri dengan kuis 15 soal untuk stimulasi neuro-kognitif.</p>
                                        </div>
                                        <div class="p-3.5 bg-emerald-50/70 border border-emerald-200 rounded-xl text-xs space-y-1">
                                            <span class="text-[9px] font-black uppercase text-emerald-700 bg-emerald-100 px-1.5 py-0.2 rounded">Cabang 2</span>
                                            <h5 class="font-bold text-emerald-950">Spaced Repetition</h5>
                                            <p class="text-slate-600 text-[11px]">Flashcards 3D dengan interval peninjauan otomatis.</p>
                                        </div>
                                        <div class="p-3.5 bg-amber-50/70 border border-amber-200 rounded-xl text-xs space-y-1">
                                            <span class="text-[9px] font-black uppercase text-amber-700 bg-amber-100 px-1.5 py-0.2 rounded">Cabang 3</span>
                                            <h5 class="font-bold text-amber-950">Gamification Dynamics</h5>
                                            <p class="text-slate-600 text-[11px]">Progression level, badge pencapaian, dan audio chime reward.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- CORE FEATURES SECTION -->
    <section id="fitur" class="py-20 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
                <span class="text-xs font-extrabold uppercase tracking-widest text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">Fitur Unggulan</span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">Semua yang Anda Butuhkan untuk Menguasai Materi</h2>
                <p class="text-xs sm:text-sm text-slate-600 font-normal">Dirancang dengan kombinasi sains kognitif modern dan kecerdasan buatan terdepan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Feature 1 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 hover:border-indigo-400 hover:shadow-lg transition-all group reveal-on-scroll parallax-item" data-speed="0.04" style="transition-delay: 50ms;">
                    <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-sm">
                        <i class="ph-bold ph-file-text"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Ekstraksi Multi-Dokumen Cerdas</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                        Unggah file PDF modul, dokumen Word (DOCX), tautan artikel online, atau teks catatan. AI langsung mengekstrak ringkasan eksekutif dan poin kunci terpenting.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 hover:border-amber-400 hover:shadow-lg transition-all group reveal-on-scroll parallax-item" data-speed="-0.03" style="transition-delay: 100ms;">
                    <div class="w-12 h-12 rounded-xl bg-amber-500 text-white flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-sm">
                        <i class="ph-bold ph-game-controller"></i>
                    </div>
                    <div class="flex items-center gap-1.5 mb-2">
                        <h3 class="text-base font-bold text-slate-900">Kuis Tantangan 15 Soal</h3>
                        <span class="bg-amber-100 text-amber-800 text-[10px] font-black px-1.5 py-0.2 rounded">+EXP</span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                        Bukan sekadar 3 soal biasa! AI menggenerasi minimal 15 soal pilihan ganda berbobot dengan navigator nomor soal interaktif dan pembahasan jawaban lengkap.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 hover:border-violet-400 hover:shadow-lg transition-all group reveal-on-scroll parallax-item" data-speed="0.04" style="transition-delay: 150ms;">
                    <div class="w-12 h-12 rounded-xl bg-violet-600 text-white flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-sm">
                        <i class="ph-bold ph-cards"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">3D Active Recall Flashcards</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                        Latih memori dengan pop-up kartu pintar 3D flip. Navigasi nyaman menggunakan tombol keyboard (Spasi & Panah) untuk belajar lebih cepat dan fokus.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 hover:border-emerald-400 hover:shadow-lg transition-all group reveal-on-scroll parallax-item" data-speed="-0.03" style="transition-delay: 100ms;">
                    <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-sm">
                        <i class="ph-bold ph-tree-structure"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Peta Konsep & Hierarki Pop-Up</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                        Lihat gambaran besar materi pembelajaran melalui pop-up hierarki berlayar luas dengan fitur zoom in/out dan visualisasi relasi cabang konsep.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 hover:border-rose-400 hover:shadow-lg transition-all group reveal-on-scroll parallax-item" data-speed="0.04" style="transition-delay: 150ms;">
                    <div class="w-12 h-12 rounded-xl bg-rose-500 text-white flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-sm">
                        <i class="ph-bold ph-trophy"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Gamifikasi & Sistem EXP Realtime</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                        Setiap kuis, kartu flashcard, dan eksplorasi peta konsep memberi reward EXP. Naikkan level belajar Anda dari Pemula hingga Legenda Ilmu!
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 hover:border-cyan-400 hover:shadow-lg transition-all group reveal-on-scroll parallax-item" data-speed="-0.03" style="transition-delay: 200ms;">
                    <div class="w-12 h-12 rounded-xl bg-cyan-600 text-white flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-sm">
                        <i class="ph-bold ph-chat-centered-dots"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Tanya Jawab Dokumen Interaktif</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                        Tanyakan bagian materi yang belum Anda pahami kapan saja. AI menjawab secara presisi dengan berpedoman langsung pada dokumen yang Anda pilih.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- HOW IT WORKS SECTION -->
    <section id="cara-kerja" class="py-20 bg-slate-50 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
                <span class="text-xs font-extrabold uppercase tracking-widest text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">Alur Belajar</span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">Hanya 3 Langkah Menuju Penguasaan Materi</h2>
                <p class="text-xs sm:text-sm text-slate-600 font-normal">Sangat praktis tanpa perlu pengaturan yang rumit.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                
                <!-- Step 1 -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm relative space-y-4 reveal-on-scroll" style="transition-delay: 50ms;">
                    <span class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-200 text-indigo-700 font-black text-sm flex items-center justify-center">1</span>
                    <h3 class="text-lg font-bold text-slate-900">Masukkan Sumber Materi</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                        Upload dokumen perkuliahan, buku digital sekolah (PDF/Word), masukkan link website artikel, atau tempel catatan teks manual Anda.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm relative space-y-4 reveal-on-scroll" style="transition-delay: 120ms;">
                    <span class="w-10 h-10 rounded-2xl bg-violet-50 border border-violet-200 text-violet-700 font-black text-sm flex items-center justify-center">2</span>
                    <h3 class="text-lg font-bold text-slate-900">AI Menghasilkan Modul</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                        Dalam beberapa detik, AI menyusun rangkuman komprehensif, 15 soal kuis evaluasi, kartu flashcard 3D, dan hierarki peta konsep secara otomatis.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm relative space-y-4 reveal-on-scroll" style="transition-delay: 190ms;">
                    <span class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-200 text-amber-700 font-black text-sm flex items-center justify-center">3</span>
                    <h3 class="text-lg font-bold text-slate-900">Taklukkan Tantangan & EXP</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                        Uji daya ingat Anda lewat kuis dan flashcard, raih EXP, pertahankan streak harian, dan rasakan peningkatan pemahaman materi secara nyata.
                    </p>
                </div>

            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('app') }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs sm:text-sm font-bold shadow-md shadow-indigo-200 transition-all hover:scale-105">
                    <span>Mulai Praktikkan Sekarang</span>
                    <i class="ph-bold ph-arrow-right"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- GAMIFICATION & EXP SHOWCASE SECTION -->
    <section id="gamifikasi" class="py-20 bg-slate-900 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
                <span class="text-xs font-extrabold uppercase tracking-widest text-amber-400 bg-amber-400/10 px-3 py-1 rounded-full border border-amber-400/20">Gamifikasi Edukatif</span>
                <h2 class="text-2xl sm:text-4xl font-black tracking-tight text-white">Sistem Tingkatan Level & Reward EXP</h2>
                <p class="text-xs sm:text-sm text-slate-400 font-normal">Belajar bukan lagi beban, melainkan petualangan naik level yang adiktif secara positif.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                
                <!-- Level 1 -->
                <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-4 text-center space-y-2 hover:border-slate-500 transition-all reveal-on-scroll" style="transition-delay: 40ms;">
                    <div class="w-10 h-10 rounded-xl bg-slate-700 text-slate-300 flex items-center justify-center text-lg mx-auto font-black">1</div>
                    <h4 class="font-extrabold text-xs text-white">Pemula</h4>
                    <p class="text-[10px] text-slate-400">0 - 100 EXP</p>
                </div>

                <!-- Level 2 -->
                <div class="bg-slate-800/80 border border-indigo-700/80 rounded-2xl p-4 text-center space-y-2 hover:border-indigo-500 transition-all reveal-on-scroll" style="transition-delay: 80ms;">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600/30 text-indigo-400 flex items-center justify-center text-lg mx-auto font-black">2</div>
                    <h4 class="font-extrabold text-xs text-indigo-300">Penjelajah</h4>
                    <p class="text-[10px] text-slate-400">101 - 250 EXP</p>
                </div>

                <!-- Level 3 -->
                <div class="bg-slate-800/80 border border-emerald-700/80 rounded-2xl p-4 text-center space-y-2 hover:border-emerald-500 transition-all reveal-on-scroll" style="transition-delay: 120ms;">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600/30 text-emerald-400 flex items-center justify-center text-lg mx-auto font-black">3</div>
                    <h4 class="font-extrabold text-xs text-emerald-300">Cendekia</h4>
                    <p class="text-[10px] text-slate-400">251 - 450 EXP</p>
                </div>

                <!-- Level 4 -->
                <div class="bg-slate-800/80 border border-violet-700/80 rounded-2xl p-4 text-center space-y-2 hover:border-violet-500 transition-all reveal-on-scroll" style="transition-delay: 160ms;">
                    <div class="w-10 h-10 rounded-xl bg-violet-600/30 text-violet-400 flex items-center justify-center text-lg mx-auto font-black">4</div>
                    <h4 class="font-extrabold text-xs text-violet-300">Pakar</h4>
                    <p class="text-[10px] text-slate-400">451 - 700 EXP</p>
                </div>

                <!-- Level 5 -->
                <div class="bg-slate-800/80 border border-amber-700/80 rounded-2xl p-4 text-center space-y-2 hover:border-amber-500 transition-all reveal-on-scroll" style="transition-delay: 200ms;">
                    <div class="w-10 h-10 rounded-xl bg-amber-600/30 text-amber-400 flex items-center justify-center text-lg mx-auto font-black">5</div>
                    <h4 class="font-extrabold text-xs text-amber-300">Master Kognitif</h4>
                    <p class="text-[10px] text-slate-400">701 - 1000 EXP</p>
                </div>

                <!-- Level 6 -->
                <div class="bg-amber-950/40 border border-amber-500 rounded-2xl p-4 text-center space-y-2 hover:border-amber-400 transition-all reveal-on-scroll" style="transition-delay: 240ms;">
                    <div class="w-10 h-10 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center text-lg mx-auto font-black">👑</div>
                    <h4 class="font-extrabold text-xs text-amber-300">Legenda Ilmu</h4>
                    <p class="text-[10px] text-amber-200/80">1000+ EXP</p>
                </div>

            </div>

        </div>
    </section>

    <!-- FAQ SECTION -->
    <section id="faq" class="py-20 bg-white border-t border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
                <span class="text-xs font-extrabold uppercase tracking-widest text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">Tanya Jawab</span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">Pertanyaan yang Sering Diajukan</h2>
            </div>

            <div class="space-y-3">
                
                <details class="group bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-5 [&_summary::-webkit-details-marker]:hidden cursor-pointer">
                    <summary class="flex items-center justify-between font-bold text-sm sm:text-base text-slate-800">
                        <span>Format dokumen apa saja yang didukung oleh Loma.AI?</span>
                        <i class="ph-bold ph-caret-down text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 font-normal leading-relaxed">
                        Loma.AI mendukung dokumen PDF materi/buku ajar, file Word (DOCX), URL/tautan artikel website, hingga teks catatan manual yang dapat langsung Anda ketik atau tempel.
                    </p>
                </details>

                <details class="group bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-5 [&_summary::-webkit-details-marker]:hidden cursor-pointer">
                    <summary class="flex items-center justify-between font-bold text-sm sm:text-base text-slate-800">
                        <span>Berapa banyak soal yang dihasilkan untuk setiap materi?</span>
                        <i class="ph-bold ph-caret-down text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 font-normal leading-relaxed">
                        Sistem AI kami telah dikonfigurasi untuk secara otomatis menghasilkan minimal 15 soal pilihan ganda komprehensif, mencakup aspek hafalan konsep, analisis, hingga studi kasus beserta kunci dan pembahasannya.
                    </p>
                </details>

                <details class="group bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-5 [&_summary::-webkit-details-marker]:hidden cursor-pointer">
                    <summary class="flex items-center justify-between font-bold text-sm sm:text-base text-slate-800">
                        <span>Bagaimana cara kerja perolehan poin EXP dan kenaikan level?</span>
                        <i class="ph-bold ph-caret-down text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 font-normal leading-relaxed">
                        Anda mendapatkan reward EXP seketika saat: menjawab kuis dengan benar (+20 EXP per soal, +150 EXP bonus nilai sempurna), menguasai flashcard (+15 EXP), mempelajari peta konsep (+30 EXP), berdiskusi aktif dengan AI (+10 EXP), serta menambahkan dokumen baru (+50 EXP).
                    </p>
                </details>

                <details class="group bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-5 [&_summary::-webkit-details-marker]:hidden cursor-pointer">
                    <summary class="flex items-center justify-between font-bold text-sm sm:text-base text-slate-800">
                        <span>Apakah saya harus membuat akun untuk mencoba platform ini?</span>
                        <i class="ph-bold ph-caret-down text-slate-400 group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 font-normal leading-relaxed">
                        Tidak harus! Anda dapat langsung menggunakan tombol "Guest" untuk mengeksplorasi seluruh fitur pembelajaran dan gamifikasi tanpa perlu mendaftar terlebih dahulu.
                    </p>
                </details>

            </div>

        </div>
    </section>

    <!-- FINAL CALL TO ACTION BANNER -->
    <section class="py-16 sm:py-24 bg-indigo-900 text-white relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-indigo-200 text-xs font-bold border border-white/20">
                <i class="ph-bold ph-sparkle text-amber-400"></i> Gratis & Siap Digunakan Kapan Saja
            </span>
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                Tingkatkan Nilai & Pemahaman Materi Anda Mulai Hari Ini
            </h2>
            <p class="text-sm sm:text-base text-indigo-200 max-w-xl mx-auto font-normal">
                Bergabunglah dengan siswa dan pembelajar mandiri yang telah merasakan kemudahan belajar dengan bantuan AI dan sistem gamifikasi terpadu.
            </p>
            <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('app') }}" class="w-full sm:w-auto px-8 py-4 bg-white hover:bg-slate-100 text-indigo-900 rounded-2xl text-sm font-black shadow-xl transition-all hover:scale-105 flex items-center justify-center gap-2">
                    <i class="ph-bold ph-rocket-launch text-indigo-600 text-lg"></i>
                    <span>Masuk ke Studio Loma.AI</span>
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 py-4 bg-white/10 hover:bg-white/20 text-white border border-white/20 rounded-2xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                    <i class="ph-bold ph-user text-lg"></i>
                    <span>Masuk / Daftar Akun</span>
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-950 text-slate-400 py-12 border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 pb-8 border-b border-slate-800/80">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-lg font-bold">
                        <i class="ph-bold ph-graduation-cap"></i>
                    </div>
                    <span class="font-extrabold text-white text-base tracking-tight">Loma<span class="text-indigo-400">.AI</span></span>
                    <span class="text-xs text-slate-500 font-medium">| Gamifikasi Pembelajaran Pintar</span>
                </div>
                <div class="flex flex-wrap items-center gap-6 text-xs font-semibold text-slate-400">
                    <a href="#fitur" class="hover:text-white transition-colors">Fitur</a>
                    <a href="#cara-kerja" class="hover:text-white transition-colors">Cara Kerja</a>
                    <a href="#gamifikasi" class="hover:text-white transition-colors">Sistem EXP</a>
                    <a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk</a>
                    <a href="{{ route('app') }}" class="hover:text-white transition-colors">Studio</a>
                </div>
            </div>
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-500 gap-3">
                <p>&copy; {{ date('Y') }} Loma.AI Gamifikasi. Seluruh hak cipta dilindungi undang-undang.</p>
                <p>Dikembangkan dengan Active Recall, Spaced Repetition, & AI Cloud Synthesis.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts: Parallax, Scroll Reveal, Tab Switcher & Smooth Page Transitions -->
    <script>
        // Tab Preview Switcher
        function switchPreviewTab(tab) {
            const tabs = ['rangkuman', 'kuis', 'flashcard', 'peta'];
            tabs.forEach(t => {
                const btn = document.getElementById(`pTab-${t}`);
                const content = document.getElementById(`pContent-${t}`);
                if (t === tab) {
                    if (btn) btn.className = "px-3 py-1.5 rounded-lg text-xs font-bold bg-indigo-600 text-white shadow-xs transition-all";
                    if (content) content.classList.remove('hidden');
                } else {
                    if (btn) btn.className = "px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all";
                    if (content) content.classList.add('hidden');
                }
            });
        }

        // High-Performance Parallax Engine (RAF Based)
        (function() {
            const parallaxItems = document.querySelectorAll('.parallax-item');
            if (!parallaxItems.length) return;

            let latestScrollY = window.pageYOffset || document.documentElement.scrollTop;
            let ticking = false;

            function updateParallax() {
                const scrollY = latestScrollY;
                const windowHeight = window.innerHeight;

                parallaxItems.forEach(item => {
                    const speed = parseFloat(item.getAttribute('data-speed')) || 0.1;
                    const rect = item.getBoundingClientRect();
                    // Calculate relative to viewport center
                    if (rect.top <= windowHeight && rect.bottom >= 0) {
                        const offset = (rect.top - windowHeight / 2) * speed;
                        item.style.transform = `translate3d(0, ${offset.toFixed(1)}px, 0)`;
                    }
                });
                ticking = false;
            }

            function onScroll() {
                latestScrollY = window.pageYOffset || document.documentElement.scrollTop;
                if (!ticking) {
                    window.requestAnimationFrame(updateParallax);
                    ticking = true;
                }
            }

            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', onScroll, { passive: true });
            updateParallax();
        })();

        // Scroll Reveal Animations (Intersection Observer)
        (function() {
            const revealElements = document.querySelectorAll('.reveal-on-scroll');
            if (!revealElements.length) return;

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            obs.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.12,
                    rootMargin: '0px 0px -40px 0px'
                });

                revealElements.forEach(el => observer.observe(el));
            } else {
                // Fallback for older browsers
                revealElements.forEach(el => el.classList.add('is-revealed'));
            }
        })();

        // Global Smooth Page Transition
        (function() {
            function initTransitions() {
                document.body.classList.add('page-loaded');

                document.addEventListener('click', function(e) {
                    const link = e.target.closest('a');
                    if (!link) return;
                    const href = link.getAttribute('href');
                    if (!href || href.startsWith('#') || href.startsWith('javascript:') || link.target === '_blank' || e.ctrlKey || e.metaKey || e.shiftKey) return;
                    if (link.origin && link.origin !== window.location.origin) return;

                    e.preventDefault();
                    const bar = document.getElementById('pageTransitionBar');
                    if (bar) bar.style.width = '100%';
                    document.body.classList.remove('page-loaded');
                    document.body.classList.add('page-leaving');
                    setTimeout(function() {
                        window.location.href = href;
                    }, 180);
                });

                window.addEventListener('pageshow', function() {
                    const bar = document.getElementById('pageTransitionBar');
                    if (bar) bar.style.width = '0%';
                    document.body.classList.remove('page-leaving');
                    document.body.classList.add('page-loaded');
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initTransitions);
            } else {
                initTransitions();
            }
        })();
    </script>
</body>
</html>
