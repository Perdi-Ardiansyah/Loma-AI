<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loma.AI Studio - Ruang Belajar Cerdas</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/bold/style.css" />
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/fill/style.css" />
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        dark: '#0f172a',      // slate-900
                        ink: '#1e293b',       // slate-800
                        slateText: '#334155', // slate-700
                        slateMuted: '#64748b',// slate-500
                        light: '#f8fafc',     // slate-50
                        surface: '#ffffff',
                        primary: '#4f46e5',   // indigo-600
                        primaryHover: '#4338ca',
                        secondary: '#10b981', // emerald-500
                        accent: '#eef2ff',    // indigo-50
                        borderLine: '#e2e8f0', // slate-200
                    }
                }
            }
        }
    </script>

    <style>
        /* Smooth Page Transition */
        body { 
            background-color: #f8fafc; 
            color: #0f172a; 
            overflow: hidden; 
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

        /* Clean Minimalist Cards */
        .clean-card, .retro-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(15, 23, 42, 0.04), 0 1px 2px -1px rgba(15, 23, 42, 0.03);
        }
        .clean-card-sm, .retro-card-sm {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: 0 1px 2px 0 rgba(15, 23, 42, 0.03);
        }

        /* Clean Modern Buttons */
        .clean-btn, .retro-btn {
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px 0 rgba(15, 23, 42, 0.05);
        }
        .clean-btn:hover, .retro-btn:hover {
            filter: brightness(0.97);
            transform: translateY(-0.5px);
        }
        .clean-btn:active, .retro-btn:active {
            transform: translateY(0);
        }

        .clean-btn-sm, .retro-btn-sm {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.12s ease;
        }
        .clean-btn-sm:hover, .retro-btn-sm:hover {
            background-color: #f1f5f9;
        }

        /* Sleek Modern Scrollbars */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* 3D Flashcard Flip */
        .perspective-1000 { perspective: 1000px; }
        .transform-style-3d { transform-style: preserve-3d; }
        .backface-hidden { backface-visibility: hidden; }
        .rotate-y-180 { transform: rotateY(180deg); }

        /* Spinner */
        .clean-spinner, .retro-spinner {
            border: 2px solid rgba(99, 102, 241, 0.2);
            border-top-color: #4f46e5;
            border-radius: 50%;
            width: 16px; height: 16px;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }
    </style>
</head>
<body class="h-screen w-screen flex flex-col font-sans bg-slate-50 text-slate-900 select-none overflow-hidden">

    <!-- Top Loading / Transition Bar -->
    <div id="pageTransitionBar" class="fixed top-0 left-0 w-0 h-1 bg-indigo-600 z-[99999] transition-all duration-300 pointer-events-none"></div>

    <!-- ========================================================
         TOP NAVBAR: BRANDING & GAMIFIKASI WIDGETS
         ======================================================== -->
    <header class="h-14 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between z-30 shrink-0">
        
        <!-- Left: Branding & Module Title -->
        <div class="flex items-center gap-3 min-w-0 shrink-0">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-2 group shrink-0">
                <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-lg shadow-sm group-hover:scale-105 transition-transform">
                    <i class="ph-bold ph-sparkle"></i>
                </div>
                <span class="text-lg font-extrabold text-slate-900 tracking-tight">
                    Loma<span class="text-indigo-600">.AI</span>
                </span>
            </a>

            <div class="h-4 w-[1px] bg-slate-200 mx-1 hidden sm:block shrink-0"></div>

            <!-- Editable Module Title (Fixed Width & Truncated) -->
            <div class="hidden sm:flex items-center gap-2 bg-slate-50 hover:bg-slate-100/80 px-3 py-1 rounded-lg border border-slate-200 cursor-pointer transition-colors max-w-[180px] sm:max-w-[200px] md:max-w-[240px] shrink-0" onclick="renameModule()" id="moduleTitleContainer" title="Klik untuk mengubah judul modul">
                <i class="ph-bold ph-book-open text-indigo-600 text-sm shrink-0"></i>
                <span class="font-semibold text-slate-800 text-xs sm:text-sm truncate" id="moduleTitle">Modul Belajar Baru</span>
                <i class="ph ph-pencil-simple text-slate-400 text-xs shrink-0"></i>
            </div>
            
            <!-- Source Status Capsule -->
            <div class="hidden md:flex items-center gap-1.5 bg-indigo-50 border border-indigo-100 text-indigo-700 px-2.5 py-0.5 rounded-full text-xs font-semibold shrink-0">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span id="headerSourceCount">0 Sumber Aktif</span>
            </div>
        </div>

        <!-- Right: Gamification Badges & Add Source Action -->
        <div class="flex items-center gap-2 sm:gap-3 shrink-0">
            <!-- Streak Badge -->
            <div class="hidden lg:flex items-center gap-1.5 bg-amber-50 border border-amber-200/80 text-amber-800 px-2.5 py-1 rounded-lg text-xs font-bold shrink-0" id="streakBadgeContainer" title="Streak Belajar Aktif">
                <i class="ph-fill ph-fire text-amber-500 text-sm shrink-0"></i>
                <span id="userStreakBadge">5 Hari Streak</span>
            </div>

            <!-- XP Level Capsule -->
            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 hover:border-indigo-300 px-2.5 py-1 rounded-lg text-xs font-bold cursor-pointer transition-all shrink-0" onclick="openLevelUpModal()" title="Klik untuk rincian level & EXP">
                <i class="ph-fill ph-trophy text-amber-500 text-sm shrink-0" id="userLevelIcon"></i>
                <div class="flex flex-col text-left leading-none shrink-0">
                    <span class="text-[9px] text-slate-500 font-bold uppercase tracking-wider" id="userLevelBadge">LEVEL 3</span>
                    <span class="font-extrabold text-slate-900 text-xs" id="userExpBadge">450 XP</span>
                </div>
                <div class="w-14 h-1.5 bg-slate-200 rounded-full overflow-hidden hidden sm:block shrink-0">
                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" id="userExpProgressBar" style="width: 50%"></div>
                </div>
            </div>

            <!-- Add Source Action Button -->
            <button onclick="openSourceModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3.5 py-1.5 rounded-lg font-semibold text-xs sm:text-sm flex items-center gap-1.5 shadow-sm transition-colors shrink-0">
                <i class="ph-bold ph-plus-circle text-base shrink-0"></i>
                <span>Tambah Sumber</span>
            </button>

            <!-- User Profile & Navigation Actions -->
            <div class="h-4 w-[1px] bg-slate-200 mx-0.5 hidden sm:block"></div>
            <a href="{{ route('landing') }}" class="text-slate-600 hover:text-indigo-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors hidden sm:flex items-center gap-1 text-xs font-semibold" title="Kembali ke Beranda Landing Page">
                <i class="ph-bold ph-house text-base"></i>
            </a>
            @if(Auth::check())
            <div class="hidden sm:flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 border border-slate-200 rounded-lg text-xs font-semibold text-slate-800">
                @if(Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-5 h-5 rounded-full object-cover border border-slate-300">
                @else
                <span class="w-5 h-5 rounded-full {{ strtolower(Auth::user()->name) === 'guest' || Auth::user()->role === 'Guest' ? 'bg-amber-500' : 'bg-indigo-600' }} text-white flex items-center justify-center text-[10px] font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
                @endif
                <span class="max-w-[110px] truncate">{{ Auth::user()->name }}</span>
                @if(strtolower(Auth::user()->name) === 'guest' || Auth::user()->role === 'Guest')
                <span class="bg-amber-100 text-amber-900 border border-amber-300 text-[9px] font-black px-1.5 py-0.2 rounded uppercase">Guest</span>
                @endif
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0">
                @csrf
                <button type="submit" class="text-slate-600 hover:text-rose-600 p-1.5 rounded-lg hover:bg-rose-50 transition-colors flex items-center gap-1 text-xs font-semibold" title="Keluar / Logout Akun">
                    <i class="ph-bold ph-sign-out text-base"></i>
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 p-1.5 rounded-lg hover:bg-indigo-50 transition-colors flex items-center gap-1 text-xs font-semibold" title="Masuk / Login">
                <i class="ph-bold ph-sign-in text-base"></i>
            </a>
            @endif
        </div>
    </header>

    <!-- MOBILE NAVIGATION TAB (Visible on < lg screens) -->
    <div class="lg:hidden bg-slate-100/70 border-b border-slate-200 px-3 py-1.5 flex gap-2 shrink-0 z-20 overflow-x-auto">
        <button onclick="switchMobileView('sources')" id="mTab-sources" class="px-3 py-1 rounded-lg text-xs font-semibold text-slate-600 shrink-0">
            <i class="ph-bold ph-files"></i> Sumber (<span id="mCount">0</span>)
        </button>
        <button onclick="switchMobileView('summary')" id="mTab-summary" class="px-3 py-1 rounded-lg text-xs font-bold bg-white text-indigo-700 border border-slate-200 shadow-sm shrink-0">
            <i class="ph-bold ph-article"></i> Rangkuman
        </button>
        <button onclick="switchMobileView('chat')" id="mTab-chat" class="px-3 py-1 rounded-lg text-xs font-semibold text-slate-600 shrink-0">
            <i class="ph-bold ph-chat-teardrop-dots"></i> Chat AI
        </button>
        <button onclick="switchMobileView('studio')" id="mTab-studio" class="px-3 py-1 rounded-lg text-xs font-semibold text-slate-600 shrink-0">
            <i class="ph-bold ph-magic-wand"></i> Studio Latihan
        </button>
    </div>

    <!-- ========================================================
         MAIN WORKSPACE (3-COLUMN SPLIT PANE)
         ======================================================== -->
    <div class="flex-grow flex overflow-hidden relative">

        <!-- ==========================================
             PANEL 1: SUMBER DOKUMEN (LEFT, ~300px)
             ========================================== -->
        <aside id="panelSources" class="w-full lg:w-72 xl:w-80 border-r border-slate-200 bg-slate-50/70 flex flex-col shrink-0 lg:flex hidden z-10 h-full">
            
            <!-- Panel Header -->
            <div class="p-3.5 border-b border-slate-200 flex items-center justify-between bg-white shrink-0">
                <div class="flex items-center gap-2">
                    <i class="ph-bold ph-files text-base text-indigo-600"></i>
                    <h2 class="font-bold text-xs uppercase tracking-wider text-slate-700">Sumber Dokumen</h2>
                </div>
                <span class="text-[11px] bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-md font-semibold text-slate-700" id="sourcesCounterBadge">0 / 10</span>
            </div>

            <!-- Toolbar / Select All -->
            <div class="px-3.5 py-2 border-b border-slate-200 bg-slate-50 flex items-center justify-between text-xs font-semibold text-slate-600 shrink-0">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" id="selectAllCheckbox" checked onchange="toggleSelectAllSources(this.checked)" class="accent-indigo-600 w-3.5 h-3.5 rounded cursor-pointer">
                    <span class="text-[11px]">Pilih Semua Sumber</span>
                </label>
                <button onclick="openSourceModal()" class="text-indigo-600 hover:text-indigo-800 flex items-center gap-1 text-[11px] font-bold transition-colors">
                    <i class="ph-bold ph-plus"></i> Tambah
                </button>
            </div>

            <!-- Sources List Items Container -->
            <div class="flex-grow overflow-y-auto p-3 space-y-2 flex flex-col" id="sourcesListContainer">
                
                <!-- Empty State (When no documents added yet) -->
                <div id="sourcesEmptyState" class="my-auto py-8 px-4 text-center flex flex-col items-center justify-center">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-xl mb-3">
                        <i class="ph-bold ph-files"></i>
                    </div>
                    <h4 class="font-bold text-xs text-slate-800 mb-1">Belum Ada Dokumen</h4>
                    <p class="text-[11px] text-slate-500 max-w-[200px] leading-relaxed mb-4">Tambahkan file PDF, DOCX, TXT atau artikel website untuk mulai belajar.</p>
                    <button onclick="openSourceModal()" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold shadow-xs flex items-center gap-1.5 transition-colors">
                        <i class="ph-bold ph-plus"></i>
                        <span>Tambah Sumber</span>
                    </button>
                </div>

            </div>

            <!-- Quick Upload Drop Area Footer -->
            <div class="p-3 border-t border-slate-200 bg-white shrink-0">
                <button onclick="openSourceModal()" class="w-full py-2 px-3 border border-dashed border-slate-300 hover:border-indigo-500 rounded-xl bg-slate-50 hover:bg-indigo-50/30 text-xs font-semibold text-slate-600 hover:text-indigo-600 flex items-center justify-center gap-2 transition-all cursor-pointer">
                    <i class="ph-bold ph-cloud-arrow-up text-base text-indigo-600"></i>
                    <span>Tarik file atau klik untuk upload</span>
                </button>
            </div>
        </aside>

        <!-- ==========================================
             PANEL 2: RUANG TENGAH (RANGKUMAN & CHAT)
             ========================================== -->
        <main id="panelCenter" class="flex-1 flex flex-col bg-white overflow-hidden z-10 border-r border-slate-200 h-full min-w-0">
            
            <!-- Center Panel Header: Tabs Switcher (Rangkuman Materi & Chat Dokumen) -->
            <div class="p-3 border-b border-slate-200 bg-white flex items-center justify-between shrink-0">
                <div class="flex items-center gap-2">
                    <!-- Segmented Pill Tabs -->
                    <div class="flex gap-1 bg-slate-100 p-1 border border-slate-200/80 rounded-xl">
                        <button onclick="switchCenterTab('summary')" id="cTab-summary" class="center-tab-btn py-1.5 px-3.5 rounded-lg text-xs font-bold bg-white text-indigo-700 shadow-sm border border-slate-200/70 flex items-center gap-1.5 transition-all">
                            <i class="ph-bold ph-article text-indigo-600"></i>
                            <span>Rangkuman Materi</span>
                        </button>
                        <button onclick="switchCenterTab('chat')" id="cTab-chat" class="center-tab-btn py-1.5 px-3.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 transition-all">
                            <i class="ph-bold ph-chat-teardrop-dots"></i>
                            <span>Chat Dokumen</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        </button>
                    </div>
                </div>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-2">
                    <button onclick="copySummaryText()" id="centerCopyBtn" class="px-2.5 py-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-lg text-xs font-medium text-slate-700 flex items-center gap-1.5 transition-colors" title="Salin Rangkuman">
                        <i class="ph-bold ph-copy text-xs"></i>
                        <span class="hidden sm:inline">Salin</span>
                    </button>
                    <button onclick="clearChatHistory()" id="centerClearChatBtn" class="hidden px-2.5 py-1.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-600 flex items-center gap-1.5 transition-colors" title="Bersihkan chat">
                        <i class="ph-bold ph-broom text-xs"></i>
                        <span class="hidden sm:inline">Bersihkan</span>
                    </button>
                </div>
            </div>

            <!-- VIEW 1: RANGKUMAN MATERI (CENTER HERO VIEW) -->
            <div id="centerContent-summary" class="flex-grow flex flex-col h-full overflow-hidden">
                <!-- Scrollable Summary Content Area -->
                <div class="flex-grow overflow-y-auto p-4 sm:p-6 space-y-5 bg-slate-50/50 flex flex-col justify-center">
                    
                    <!-- EMPTY STATE: Belum ada materi diekstrak -->
                    <div id="summaryEmptyState" class="max-w-md w-full mx-auto bg-white border border-slate-200 rounded-2xl p-7 sm:p-9 shadow-sm text-center my-auto">
                        <div class="w-16 h-16 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-3xl mx-auto mb-4">
                            <i class="ph-bold ph-sparkle"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-2">Mulai Ruang Belajar Anda</h3>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6 font-normal">
                            Belum ada materi pembelajaran yang aktif. Unggah dokumen catatan, materi kuliah (PDF, Word), atau tautan artikel di panel kiri untuk mengekstrak rangkuman, kuis, dan flashcard cerdas secara otomatis.
                        </p>
                        <button onclick="openSourceModal()" class="w-full sm:w-auto px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm inline-flex items-center justify-center gap-2 transition-all">
                            <i class="ph-bold ph-plus-circle text-base"></i>
                            <span>Unggah Dokumen Sekarang</span>
                        </button>
                    </div>

                    <!-- HERO DOCUMENT TITLE & ACTIVE SUMMARY (Tampil setelah file diproses) -->
                    <div id="summaryHeroCard" class="hidden bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                            <div>
                                <span class="inline-flex items-center gap-1.5 bg-indigo-50 border border-indigo-100 text-indigo-700 px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider mb-2">
                                    <i class="ph-bold ph-sparkle text-indigo-600"></i> Ekstraksi Materi AI
                                </span>
                                <h2 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight" id="summaryHeroTitle">
                                    Judul Materi
                                </h2>
                                <p class="text-xs text-slate-500 mt-1">Dihasilkan secara otomatis dari analisis dokumen yang aktif</p>
                            </div>

                            <!-- Quick Studio Launcher Actions -->
                            <div class="flex items-center gap-2">
                                <button onclick="openQuizModal()" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-xs hover:scale-[1.02]">
                                    <i class="ph-bold ph-game-controller text-amber-600 text-sm"></i>
                                    <span id="quickQuizBtnText">Kuis Soal</span>
                                    <span class="bg-amber-200/80 text-amber-900 text-[9px] px-1 rounded font-black">+EXP</span>
                                </button>
                                <button onclick="openFlashcardModal()" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-xl text-xs font-bold flex items-center gap-1.5 transition-all shadow-xs hover:scale-[1.02]">
                                    <i class="ph-bold ph-cards text-indigo-600 text-sm"></i>
                                    <span>Flashcard</span>
                                </button>
                            </div>
                        </div>

                        <!-- Main Executive Summary & Key Points Container -->
                        <div id="summaryContainer" class="text-sm text-slate-800 font-normal leading-relaxed space-y-4">
                            <!-- Ringkasan Eksekutif & Poin Kunci di-render dinamis oleh JS -->
                        </div>
                    </div>
                </div>

                <!-- Pinned Bottom Bar: Ask About This Summary (Does NOT scroll) -->
                <div class="p-3 bg-white border-t border-slate-200 shrink-0 shadow-xs">
                    <div class="bg-slate-50 hover:bg-slate-100/70 border border-slate-200/90 rounded-xl p-2.5 sm:p-3 flex items-center gap-2 transition-colors">
                        <i class="ph-bold ph-chat-teardrop-dots text-indigo-600 text-base"></i>
                        <input type="text" id="quickSummaryQuestion" placeholder="Ada bagian yang belum dipahami? Tanyakan ke AI..." class="flex-grow text-xs sm:text-sm font-normal text-slate-800 placeholder-slate-400 bg-transparent focus:outline-none" onkeydown="handleQuickSummaryKeydown(event)">
                        <button onclick="handleQuickSummarySubmit()" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors flex items-center gap-1 shrink-0">
                            <span>Tanya</span>
                            <i class="ph-bold ph-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- VIEW 2: CHAT DOKUMEN (INTERACTIVE AI Q&A) -->
            <div id="centerContent-chat" class="flex-grow flex flex-col hidden h-full overflow-hidden">
                <!-- Chat Stream Feed (Scrollable) -->
                <div class="flex-grow overflow-y-auto p-4 sm:p-5 space-y-4" id="chatStream">
                    
                    <!-- Welcome Banner -->
                    <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-xs">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-lg shrink-0 shadow-sm">
                                <i class="ph-bold ph-sparkle"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-slate-800 mb-0.5">Diskusi dengan AI tentang Dokumen</h3>
                                <p class="text-xs text-slate-600 font-normal leading-relaxed">
                                    Tanyakan apa saja seputar materi, uji pemahaman topik tertentu, atau gunakan rekomendasi di bawah ini:
                                </p>
                            </div>
                        </div>

                        <!-- Prompt Suggestion Chips -->
                        <div class="mt-3.5 pt-3 border-t border-slate-100 flex flex-wrap gap-2">
                            <button onclick="sendQuickPrompt('Ringkas poin-poin terpenting dari seluruh dokumen')" class="px-3 py-1.5 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-lg text-xs font-medium text-slate-700 shadow-sm flex items-center gap-1.5 transition-colors">
                                <i class="ph-fill ph-lightbulb text-amber-500"></i>
                                <span>Ringkas poin-poin penting</span>
                            </button>
                            <button onclick="sendQuickPrompt('Jelaskan apa itu Active Recall dan cara kerjanya')" class="px-3 py-1.5 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-lg text-xs font-medium text-slate-700 shadow-sm flex items-center gap-1.5 transition-colors">
                                <i class="ph-fill ph-brain text-indigo-500"></i>
                                <span>Jelaskan Active Recall</span>
                            </button>
                            <button onclick="sendQuickPrompt('Buat 3 pertanyaan evaluasi pemahaman beserta jawabannya')" class="px-3 py-1.5 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-lg text-xs font-medium text-slate-700 shadow-sm flex items-center gap-1.5 transition-colors">
                                <i class="ph-fill ph-target text-emerald-500"></i>
                                <span>Buat pertanyaan ujian</span>
                            </button>
                            <button onclick="sendQuickPrompt('Bagaimana hubungan antara gamifikasi dengan tingkat motivasi belajar?')" class="px-3 py-1.5 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-lg text-xs font-medium text-slate-700 shadow-sm flex items-center gap-1.5 transition-colors">
                                <i class="ph-fill ph-fire text-amber-500"></i>
                                <span>Gamifikasi & Motivasi</span>
                            </button>
                        </div>
                    </div>

                    <!-- Sample AI Conversation -->
                    <div class="flex items-start gap-2.5">
                        <div class="w-7 h-7 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold shrink-0 shadow-sm">
                            AI
                        </div>
                        <div class="max-w-[88%] bg-slate-50 border border-slate-200 rounded-2xl rounded-tl-sm p-3.5 text-xs sm:text-sm text-slate-800 leading-relaxed font-normal shadow-sm">
                            <p class="mb-2">Berdasarkan 3 dokumen yang diunggah, materi ini berfokus pada integrasi <strong>Gamifikasi</strong> dan metode <strong>Active Recall</strong> dalam pembelajaran mandiri.</p>
                            
                            <p class="mb-1.5 font-semibold text-slate-800">Tiga pilar utamanya meliputi:</p>
                            <ul class="list-disc pl-4 space-y-1 mb-2.5 text-slate-700">
                                <li><strong>Loop Motivasi:</strong> Penerapan poin (EXP), level, dan streak harian untuk menjaga konsistensi belajar <span class="inline-block bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-semibold px-1.5 py-0.2 rounded cursor-pointer" title="Sumber: Modul_1_Gamifikasi.pdf">[1]</span>.</li>
                                <li><strong>Spaced Repetition:</strong> Interval pengulangan materi menggunakan kartu pintar agar materi tersimpan di memori jangka panjang <span class="inline-block bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-semibold px-1.5 py-0.2 rounded cursor-pointer" title="Sumber: Catatan_Kuliah_Bab2.docx">[2]</span>.</li>
                                <li><strong>AI Extractor:</strong> Otomatisasi pengubahan dokumen menjadi kuis interaktif dan ringkasan suara <span class="inline-block bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-semibold px-1.5 py-0.2 rounded cursor-pointer" title="Sumber: artikel-edutech.com">[3]</span>.</li>
                            </ul>

                            <div class="text-[10px] text-slate-400 pt-2 border-t border-slate-200/80 flex items-center gap-1.5 font-medium">
                                <i class="ph-fill ph-check-circle text-emerald-500"></i> Divalidasi dari 3 dokumen sumber
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sticky Chat Prompt Input Container -->
                <div class="p-3 border-t border-slate-200 bg-white shrink-0">
                    <form id="chatForm" onsubmit="handleSendChat(event)" class="relative flex items-center gap-2 bg-slate-50 border border-slate-300 focus-within:border-indigo-500 focus-within:bg-white focus-within:ring-2 focus-within:ring-indigo-100 rounded-xl px-3 py-1.5 shadow-sm transition-all">
                        <button type="button" onclick="openSourceModal()" class="text-slate-400 hover:text-slate-700 transition-colors p-1" title="Tambah Lampiran Sumber">
                            <i class="ph-bold ph-paperclip text-lg"></i>
                        </button>
                        
                        <textarea id="chatInput" rows="1" class="flex-grow max-h-28 py-1 px-1 text-xs sm:text-sm font-normal text-slate-800 placeholder-slate-400 bg-transparent focus:outline-none resize-none leading-relaxed" placeholder="Tanyakan apa saja tentang dokumen Anda... (Enter untuk kirim)" onkeydown="handleTextareaKeydown(event)"></textarea>

                        <button type="submit" id="sendBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white w-8 h-8 rounded-lg flex items-center justify-center shrink-0 shadow-sm transition-colors" title="Kirim Pertanyaan">
                            <i class="ph-fill ph-paper-plane-right text-sm"></i>
                        </button>
                    </form>
                    <div class="flex justify-between items-center px-1 mt-1.5 text-[10px] text-slate-400 font-medium">
                        <span>Shift + Enter untuk baris baru</span>
                        <span>Loma.AI merujuk langsung pada dokumen terunggah</span>
                    </div>
                </div>
            </div>
        </main>

        <!-- ==========================================
             PANEL 3: STUDIO & GAMIFIKASI (RIGHT, ~380px)
             ========================================== -->
        <aside id="panelStudio" class="w-full lg:w-80 xl:w-96 bg-slate-50/70 border-l border-slate-200 flex flex-col shrink-0 lg:flex hidden overflow-y-auto h-full">
            
            <!-- Studio Header -->
            <div class="p-3.5 border-b border-slate-200 bg-white flex items-center justify-between sticky top-0 z-20 shrink-0">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-md bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center text-xs">
                        <i class="ph-fill ph-magic-wand"></i>
                    </div>
                    <h2 class="font-bold text-xs uppercase tracking-wider text-slate-700">Studio Latihan</h2>
                </div>
                <span class="text-[10px] font-semibold bg-indigo-50 border border-indigo-200 px-2 py-0.5 rounded text-indigo-700">Gamifikasi Mode</span>
            </div>

            <!-- Studio Contents Area: Feature Launchers as Popups -->
            <div class="p-3.5 space-y-3 flex-grow">
                
                <!-- CARD 1: KUIS ACTIVE RECALL POPUP LAUNCHER -->
                <div class="clean-card p-4 bg-white hover:border-amber-500 hover:shadow-md transition-all group border border-slate-200">
                    <div class="flex items-start justify-between mb-2">
                        <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xl shadow-sm group-hover:scale-105 transition-transform">
                            <i class="ph-bold ph-game-controller"></i>
                        </div>
                        <span class="bg-amber-100 text-amber-900 border border-amber-200 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full flex items-center gap-1 shadow-xs">
                            <i class="ph-fill ph-star text-amber-600"></i> +20 EXP / Soal
                        </span>
                    </div>
                    <h3 class="font-bold text-sm text-slate-800 flex items-center gap-1.5" id="studioQuizTitle">
                        Kuis Tantangan Active Recall
                    </h3>
                    <p class="text-xs text-slate-500 font-normal mt-1 leading-relaxed">
                        Evaluasi komprehensif menguji pemahaman materi. Tampilan pop-up layar penuh yang nyaman dengan review pembahasan instan.
                    </p>
                    <div class="mt-3.5 flex items-center justify-between pt-2.5 border-t border-slate-100">
                        <div class="text-[11px] font-semibold text-slate-600 flex items-center gap-1">
                            <i class="ph-bold ph-check-square-offset text-amber-600"></i>
                            <span id="studioQuizCount">0 Soal Tersedia</span>
                        </div>
                        <button onclick="openQuizModal()" class="px-3.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold shadow-sm flex items-center gap-1.5 transition-all hover:gap-2">
                            <span>Mulai Kuis</span>
                            <i class="ph-bold ph-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- CARD 2: FLASHCARD POPUP LAUNCHER -->
                <div class="clean-card p-4 bg-white hover:border-indigo-500 hover:shadow-md transition-all group border border-slate-200">
                    <div class="flex items-start justify-between mb-2">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-xl shadow-sm group-hover:scale-105 transition-transform">
                            <i class="ph-bold ph-cards"></i>
                        </div>
                        <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full flex items-center gap-1 shadow-xs">
                            <i class="ph-bold ph-sparkle text-indigo-600"></i> +15 EXP / Kartu
                        </span>
                    </div>
                    <h3 class="font-bold text-sm text-slate-800 flex items-center gap-1.5">
                        Flashcard Active Recall
                    </h3>
                    <p class="text-xs text-slate-500 font-normal mt-1 leading-relaxed">
                        Kartu pintar interaktif dengan efek balik 3D. Maksimalkan memori jangka panjang melalui Spaced Repetition.
                    </p>
                    <div class="mt-3.5 flex items-center justify-between pt-2.5 border-t border-slate-100">
                        <div class="text-[11px] font-semibold text-slate-600 flex items-center gap-1">
                            <i class="ph-bold ph-stack text-indigo-600"></i>
                            <span id="studioCardCount">0 Kartu Aktif</span>
                        </div>
                        <button onclick="openFlashcardModal()" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold shadow-sm flex items-center gap-1.5 transition-all hover:gap-2">
                            <span>Buka Flashcard</span>
                            <i class="ph-bold ph-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- CARD 3: PETA KONSEP POPUP LAUNCHER -->
                <div class="clean-card p-4 bg-white hover:border-emerald-500 hover:shadow-md transition-all group border border-slate-200">
                    <div class="flex items-start justify-between mb-2">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xl shadow-sm group-hover:scale-105 transition-transform">
                            <i class="ph-bold ph-tree-structure"></i>
                        </div>
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full flex items-center gap-1 shadow-xs">
                            <i class="ph-bold ph-compass text-emerald-600"></i> +30 EXP Eksplorasi
                        </span>
                    </div>
                    <h3 class="font-bold text-sm text-slate-800 flex items-center gap-1.5">
                        Peta Konsep & Hirarki
                    </h3>
                    <p class="text-xs text-slate-500 font-normal mt-1 leading-relaxed">
                        Visualisasi diagram pohon menyeluruh yang menghubungkan topik sentral dengan cabang-cabang materi penting.
                    </p>
                    <div class="mt-3.5 flex items-center justify-between pt-2.5 border-t border-slate-100">
                        <div class="text-[11px] font-semibold text-slate-600 flex items-center gap-1">
                            <i class="ph-bold ph-git-fork text-emerald-600"></i>
                            <span id="studioBranchesCount">0 Cabang Konsep</span>
                        </div>
                        <button onclick="openConceptMapModal()" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-sm flex items-center gap-1.5 transition-all hover:gap-2">
                            <span>Lihat Diagram</span>
                            <i class="ph-bold ph-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- CARD 4: PUSAT GAMIFIKASI & MISI EXP -->
                <div class="clean-card p-4 bg-slate-900 text-white rounded-2xl shadow-md border border-slate-800 relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl pointer-events-none"></div>
                    
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-amber-400 text-slate-900 flex items-center justify-center text-sm font-black">
                                <i class="ph-fill ph-trophy"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-amber-300">Statistik EXP Belajar</h4>
                                <div class="text-[10px] text-slate-400" id="userRankTitle">Pelajar Tangguh • Level 3</div>
                            </div>
                        </div>
                        <span class="text-xs font-black text-amber-400 font-mono" id="hubExpText">450 XP</span>
                    </div>

                    <!-- Progress to Next Level -->
                    <div class="space-y-1 mb-3">
                        <div class="flex justify-between text-[10px] font-semibold text-slate-300">
                            <span>Progres Level</span>
                            <span id="hubProgressText">50% menuju Level 4</span>
                        </div>
                        <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden border border-slate-700">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" id="hubProgressBar" style="width: 50%"></div>
                        </div>
                    </div>

                    <!-- Misi EXP Harian -->
                    <div class="pt-2.5 border-t border-slate-800 space-y-1.5">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Misi Harian:</div>
                        <div class="flex items-center justify-between text-[11px] p-1.5 bg-slate-800/80 rounded-lg">
                            <span class="flex items-center gap-1.5 text-slate-200">
                                <i class="ph-fill ph-check-circle text-emerald-400" id="questCheckKuis"></i> Selesaikan Kuis 15 Soal
                            </span>
                            <span class="text-amber-300 font-bold text-[10px]">+300 XP</span>
                        </div>
                        <div class="flex items-center justify-between text-[11px] p-1.5 bg-slate-800/80 rounded-lg">
                            <span class="flex items-center gap-1.5 text-slate-200">
                                <i class="ph-fill ph-check-circle text-emerald-400" id="questCheckCard"></i> Kuasai Flashcard
                            </span>
                            <span class="text-amber-300 font-bold text-[10px]">+75 XP</span>
                        </div>
                        <div class="flex items-center justify-between text-[11px] p-1.5 bg-slate-800/80 rounded-lg">
                            <span class="flex items-center gap-1.5 text-slate-200">
                                <i class="ph-fill ph-check-circle text-emerald-400" id="questCheckMap"></i> Jelajahi Peta Konsep
                            </span>
                            <span class="text-amber-300 font-bold text-[10px]">+30 XP</span>
                        </div>
                    </div>
                </div>

            </div>
        </aside>

    </div>

    <!-- ========================================================
         MODAL: TAMBAH SUMBER DOKUMEN (+ ADD SOURCES MODAL)
         ======================================================== -->
    <div id="sourceModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
        <div class="clean-card max-w-lg w-full p-5 bg-white transform scale-95 transition-all duration-300 shadow-xl border border-slate-200 rounded-2xl" id="sourceModalCard">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                        <i class="ph-fill ph-folder-notch-plus text-base"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Tambah Sumber Materi</h3>
                        <p class="text-[11px] text-slate-500">Mendukung PDF, Word, PowerPoint, URL, & Catatan Teks</p>
                    </div>
                </div>
                <button onclick="closeSourceModal()" class="w-7 h-7 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors">
                    <i class="ph-bold ph-x text-xs"></i>
                </button>
            </div>

            <!-- Tab Switcher Modal -->
            <div class="flex gap-1.5 p-1 bg-slate-100 rounded-xl mb-4">
                <button onclick="switchModalTab('file')" id="mTabModal-file" class="modal-tab-btn flex-1 py-1.5 rounded-lg text-xs font-bold bg-white text-indigo-700 shadow-sm flex items-center justify-center gap-1.5">
                    <i class="ph-bold ph-file-arrow-up text-sm"></i> File Dokumen
                </button>
                <button onclick="switchModalTab('url')" id="mTabModal-url" class="modal-tab-btn flex-1 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center justify-center gap-1.5">
                    <i class="ph-bold ph-link text-sm"></i> Link URL
                </button>
                <button onclick="switchModalTab('text')" id="mTabModal-text" class="modal-tab-btn flex-1 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center justify-center gap-1.5">
                    <i class="ph-bold ph-text-aa text-sm"></i> Teks Manual
                </button>
            </div>

            <!-- TAB 1: FILE UPLOAD -->
            <div id="modalContent-file" class="modal-content block">
                <div class="border-2 border-dashed border-slate-300 hover:border-indigo-500 bg-slate-50/60 hover:bg-indigo-50/20 rounded-xl p-5 text-center cursor-pointer relative transition-all" id="modalDropzone">
                    <input type="file" id="modalFileInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt" onchange="handleModalFileChange(this)">
                    <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl border border-indigo-100 flex items-center justify-center text-xl mx-auto mb-2">
                        <i class="ph-bold ph-file-arrow-up"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-xs sm:text-sm mb-0.5" id="dropzoneTitle">Pilih Dokumen Anda</h4>
                    <p class="text-[11px] text-slate-500 mb-2.5">Seret file ke sini, atau klik untuk browse</p>
                    <div class="flex justify-center gap-1.5">
                        <span class="bg-white border border-slate-200 text-slate-600 text-[9px] font-semibold px-2 py-0.5 rounded shadow-sm">PDF</span>
                        <span class="bg-white border border-slate-200 text-slate-600 text-[9px] font-semibold px-2 py-0.5 rounded shadow-sm">DOCX</span>
                        <span class="bg-white border border-slate-200 text-slate-600 text-[9px] font-semibold px-2 py-0.5 rounded shadow-sm">PPTX</span>
                    </div>
                </div>
            </div>

            <!-- TAB 2: LINK URL -->
            <div id="modalContent-url" class="modal-content hidden">
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Tautan Artikel atau Website</label>
                    <div class="relative">
                        <i class="ph-bold ph-link absolute left-3 top-2.5 text-base text-slate-400"></i>
                        <input type="url" id="modalUrlInput" placeholder="https://contoh.com/artikel-edukasi" class="w-full bg-white border border-slate-300 rounded-lg py-2 pl-9 pr-3 text-xs sm:text-sm font-normal text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm">
                    </div>
                    <p class="text-[10px] text-slate-500 mt-2">AI akan mengekstrak isi teks utama dari halaman website tersebut secara otomatis.</p>
                </div>
            </div>

            <!-- TAB 3: TEKS MANUAL -->
            <div id="modalContent-text" class="modal-content hidden">
                <textarea id="modalTextInput" rows="5" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs sm:text-sm font-normal text-slate-800 placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm" placeholder="Tempelkan catatan atau materi teks Anda di sini..."></textarea>
            </div>

            <!-- Modal Action Buttons -->
            <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button onclick="closeSourceModal()" class="px-4 py-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 font-semibold text-xs text-slate-600 transition-colors">
                    Batal
                </button>
                <button onclick="processAddSource()" id="btnProcessSource" class="px-5 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs shadow-sm flex items-center gap-1.5 transition-colors">
                    <span id="btnProcessText">Tambahkan Sumber</span>
                    <i class="ph-bold ph-arrow-right" id="btnProcessIcon"></i>
                    <div class="clean-spinner hidden" id="btnProcessSpinner"></div>
                </button>
            </div>

        </div>
    </div>

    <!-- ========================================================
         CELEBRATORY LEVEL-UP MODAL (GAMIFICATION REWARD)
         ======================================================== -->
    <!-- ========================================================
         POP-UP MODAL 1: KUIS TANTANGAN ACTIVE RECALL (15 SOAL)
         ======================================================== -->
    <div id="quizModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-3 sm:p-6 opacity-0 pointer-events-none transition-all duration-300">
        <div class="clean-card max-w-4xl w-full max-h-[92vh] flex flex-col bg-white transform scale-95 transition-all duration-300 shadow-2xl rounded-2xl border border-slate-200 overflow-hidden" id="quizModalCard">
            
            <!-- Modal Header -->
            <div class="p-4 sm:p-5 border-b border-slate-100 bg-white flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-center text-amber-600 text-xl shadow-xs">
                        <i class="ph-fill ph-game-controller"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-base sm:text-lg text-slate-800">Ujian Tantangan Active Recall</h3>
                            <span class="bg-amber-100 text-amber-900 border border-amber-200 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">+20 EXP / Soal</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Uji pemahaman mendalam materi dengan 15 pertanyaan pilihan ganda</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="toggleQuizViewMode()" id="quizViewToggleBtn" class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 text-xs font-semibold text-slate-700 transition-colors" title="Ubah mode tampilan">
                        <i class="ph-bold ph-list-numbers"></i>
                        <span id="quizViewToggleText">Tampilkan Semua Soal</span>
                    </button>
                    <button onclick="closeQuizModal()" class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors">
                        <i class="ph-bold ph-x text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Question Numbers Navigator Bar -->
            <div class="px-4 py-2.5 bg-slate-50/80 border-b border-slate-200/80 flex items-center justify-between gap-2 overflow-x-auto shrink-0 select-none">
                <div class="flex items-center gap-1.5" id="quizNavPills">
                    <!-- 15 Question Navigation Pills dynamically rendered -->
                </div>
                <div class="text-[11px] font-bold text-slate-500 shrink-0" id="quizAnsweredCountContainer">
                    Dijawab: <span id="quizAnsweredCount" class="text-indigo-600">0</span>/<span id="quizTotalCount">15</span>
                </div>
            </div>

            <!-- Modal Body: Quiz Questions Content -->
            <div class="flex-grow overflow-y-auto p-4 sm:p-6 bg-slate-50/40" id="quizModalBody">
                
                <!-- Single Question View Container -->
                <div id="quizSingleViewContainer" class="max-w-2xl mx-auto space-y-4">
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-3 text-xs font-bold text-slate-500">
                            <span class="bg-indigo-50 text-indigo-700 border border-indigo-100 px-2.5 py-0.5 rounded-full" id="quizCurrentIndexBadge">Soal 1 dari 15</span>
                            <span class="text-slate-400 font-mono" id="quizSingleRewardBadge">+20 EXP</span>
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-sm sm:text-base mb-4 leading-relaxed" id="quizSingleQuestionText">
                            <!-- Question Text -->
                        </h4>

                        <!-- Options List -->
                        <div class="space-y-2.5" id="quizSingleOptionsContainer">
                            <!-- 4 Options rendered by JS -->
                        </div>

                        <!-- Explanation Box (Appears after answer checked) -->
                        <div id="quizSingleExplanationBox" class="mt-4 p-3.5 rounded-xl text-xs font-medium border hidden transition-all"></div>
                    </div>
                </div>

                <!-- All Questions View Container (Alternative Mode) -->
                <div id="quizAllViewContainer" class="hidden max-w-3xl mx-auto space-y-4">
                    <!-- Rendered by JS -->
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="p-3.5 sm:p-4 border-t border-slate-100 bg-white flex flex-col sm:flex-row items-center justify-between gap-3 shrink-0">
                <div class="flex items-center gap-2 w-full sm:w-auto justify-between sm:justify-start">
                    <button onclick="prevQuizQuestion()" id="quizPrevBtn" class="px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-xs font-bold text-slate-700 flex items-center gap-1.5 transition-colors">
                        <i class="ph-bold ph-caret-left"></i>
                        <span>Sebelumnya</span>
                    </button>
                    <button onclick="nextQuizQuestion()" id="quizNextBtn" class="px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-xs font-bold text-slate-700 flex items-center gap-1.5 transition-colors">
                        <span>Selanjutnya</span>
                        <i class="ph-bold ph-caret-right"></i>
                    </button>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                    <div id="quizResultBanner" class="text-xs font-bold text-slate-700"></div>
                    <button onclick="submitQuizAnswers()" id="quizSubmitBtn" class="w-full sm:w-auto px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-sm flex items-center justify-center gap-2 transition-all hover:scale-[1.02]">
                        <i class="ph-bold ph-check-circle text-base"></i>
                        <span>Cek Jawaban & Klaim EXP</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- ========================================================
         POP-UP MODAL 2: FLASHCARD ACTIVE RECALL
         ======================================================== -->
    <div id="flashcardModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-3 sm:p-6 opacity-0 pointer-events-none transition-all duration-300">
        <div class="clean-card max-w-2xl w-full max-h-[92vh] flex flex-col bg-white transform scale-95 transition-all duration-300 shadow-2xl rounded-2xl border border-slate-200 overflow-hidden" id="flashcardModalCard">
            
            <!-- Modal Header -->
            <div class="p-4 sm:p-5 border-b border-slate-100 bg-white flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-200 flex items-center justify-center text-indigo-600 text-xl shadow-xs">
                        <i class="ph-fill ph-cards"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-base sm:text-lg text-slate-800">Flashcard Active Recall</h3>
                            <span class="bg-indigo-100 text-indigo-800 border border-indigo-200 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">+15 EXP Tiap Kartu</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Latih penarikan memori aktif (Retrieval Practice) secara bertahap</p>
                    </div>
                </div>
                <button onclick="closeFlashcardModal()" class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors">
                    <i class="ph-bold ph-x text-sm"></i>
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-slate-100 h-1.5 shrink-0">
                <div class="bg-indigo-600 h-full transition-all duration-300" id="fcProgressBar" style="width: 20%"></div>
            </div>

            <!-- Modal Body: 3D Flip Card -->
            <div class="flex-grow p-4 sm:p-8 flex flex-col items-center justify-center bg-slate-50/60">
                
                <div class="w-full max-w-lg h-72 sm:h-80 relative perspective-1000 cursor-pointer" onclick="flipFlashcard()">
                    <div id="flashcardModalFlippable" class="w-full h-full relative transition-transform duration-500 transform-style-3d">
                        
                        <!-- CARD FRONT -->
                        <div class="absolute inset-0 bg-indigo-700 text-white rounded-2xl border-2 border-indigo-600 p-6 sm:p-8 flex flex-col justify-between backface-hidden shadow-xl select-none">
                            <div class="flex items-center justify-between">
                                <span class="bg-indigo-900/60 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">
                                    Pertanyaan / Konsep
                                </span>
                                <span class="text-xs font-mono font-bold text-indigo-200" id="fcModalCounter">1 / 5</span>
                            </div>

                            <div class="my-auto text-center">
                                <h4 id="fcModalFrontText" class="text-lg sm:text-xl font-black text-white leading-relaxed">
                                    Apa perbedaan Active Recall dan Passive Reading?
                                </h4>
                            </div>

                            <div class="flex items-center justify-center gap-1.5 text-xs text-indigo-200 font-medium">
                                <i class="ph-bold ph-arrows-clockwise text-sm"></i>
                                <span>Klik kartu atau tekan Spasi untuk membalik jawaban</span>
                            </div>
                        </div>

                        <!-- CARD BACK -->
                        <div class="absolute inset-0 bg-emerald-700 text-white rounded-2xl border-2 border-emerald-600 p-6 sm:p-8 flex flex-col justify-between backface-hidden rotate-y-180 shadow-xl select-none">
                            <div class="flex items-center justify-between">
                                <span class="bg-emerald-900/60 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">
                                    Jawaban & Elaborasi
                                </span>
                                <span class="text-xs font-mono font-bold text-emerald-200" id="fcModalCounterBack">1 / 5</span>
                            </div>

                            <div class="my-auto text-center">
                                <p id="fcModalBackText" class="text-sm sm:text-base font-semibold leading-relaxed">
                                    Active recall melatih otak memanggil memori secara aktif, sedangkan passive reading hanya membaca ulang tanpa menguji daya ingat.
                                </p>
                            </div>

                            <div class="flex items-center justify-center gap-1.5 text-xs text-emerald-200 font-medium">
                                <i class="ph-fill ph-check-circle text-base"></i>
                                <span>Konsep siap diuji di sesi kuis!</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Mastery Status Buttons below Card -->
                <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                    <button onclick="flipFlashcard()" class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-xs font-bold text-slate-700 shadow-sm flex items-center gap-1.5 transition-colors">
                        <i class="ph-bold ph-arrows-clockwise text-sm"></i>
                        <span>Balik Kartu</span>
                    </button>
                    <button onclick="markFlashcardMastered(false)" class="px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold shadow-sm flex items-center gap-1.5 transition-colors">
                        <i class="ph-bold ph-arrow-counter-clockwise"></i>
                        <span>Belum Paham (Ulangi)</span>
                    </button>
                    <button onclick="markFlashcardMastered(true)" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm flex items-center gap-1.5 transition-all hover:scale-105">
                        <i class="ph-bold ph-check"></i>
                        <span>Sudah Paham (+15 EXP)</span>
                    </button>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="p-3.5 sm:p-4 border-t border-slate-100 bg-white flex items-center justify-between shrink-0">
                <button onclick="prevFlashcard()" class="px-4 py-2 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-xs font-bold text-slate-700 flex items-center gap-1.5 transition-colors">
                    <i class="ph-bold ph-caret-left"></i>
                    <span>Sebelumnya</span>
                </button>
                <span class="text-xs text-slate-400 font-medium hidden sm:inline">Tekan tombol panah ← / → di keyboard</span>
                <button onclick="nextFlashcard()" class="px-4 py-2 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-xs font-bold text-slate-700 flex items-center gap-1.5 transition-colors">
                    <span>Selanjutnya</span>
                    <i class="ph-bold ph-caret-right"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- ========================================================
         POP-UP MODAL 3: PETA KONSEP & HIRARKI (LUAS & JELAS)
         ======================================================== -->
    <div id="conceptMapModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-3 sm:p-6 opacity-0 pointer-events-none transition-all duration-300">
        <div class="clean-card max-w-5xl w-full max-h-[92vh] flex flex-col bg-white transform scale-95 transition-all duration-300 shadow-2xl rounded-2xl border border-slate-200 overflow-hidden" id="conceptMapModalCard">
            
            <!-- Modal Header -->
            <div class="p-4 sm:p-5 border-b border-slate-100 bg-white flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-600 text-xl shadow-xs">
                        <i class="ph-fill ph-tree-structure"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-base sm:text-lg text-slate-800">Peta Konsep & Hirarki Materi</h3>
                            <span class="bg-emerald-100 text-emerald-800 border border-emerald-200 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">+30 EXP Eksplorasi</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Diagram visual alur penalaran dan hubungan antar konsep esensial</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="zoomConceptMap(0.1)" class="w-8 h-8 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 flex items-center justify-center transition-colors" title="Perbesar">
                        <i class="ph-bold ph-magnifying-glass-plus text-sm"></i>
                    </button>
                    <button onclick="zoomConceptMap(-0.1)" class="w-8 h-8 rounded-lg border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 flex items-center justify-center transition-colors" title="Perkecil">
                        <i class="ph-bold ph-magnifying-glass-minus text-sm"></i>
                    </button>
                    <button onclick="closeConceptMapModal()" class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors">
                        <i class="ph-bold ph-x text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body: Mind Map Canvas -->
            <div class="flex-grow overflow-y-auto overflow-x-auto p-6 sm:p-8 bg-slate-50/70" id="conceptMapCanvasWrapper">
                
                <div class="max-w-4xl mx-auto space-y-6 transition-transform duration-200 origin-top" id="conceptMapContent">
                    
                    <!-- Central Root Node -->
                    <div class="p-6 bg-indigo-700 text-white rounded-2xl shadow-lg border-2 border-indigo-600 text-center relative max-w-xl mx-auto">
                        <span class="bg-indigo-900/60 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider inline-block mb-2">
                            Topik Utama Materi
                        </span>
                        <h2 class="text-lg sm:text-2xl font-black tracking-tight" id="modalRootConceptTitle">
                            🧠 Pembelajaran Berbasis Gamifikasi
                        </h2>
                        <p class="text-xs sm:text-sm text-indigo-100 mt-2 font-normal leading-relaxed">
                            Integrasi mekanik game dan active recall untuk membangun retensi memori jangka panjang.
                        </p>
                    </div>

                    <!-- Flow Line Down -->
                    <div class="flex flex-col items-center text-slate-300">
                        <div class="w-[2px] h-6 bg-indigo-300"></div>
                        <i class="ph-bold ph-caret-down text-indigo-400 text-base -mt-1"></i>
                    </div>

                    <!-- Branches Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5" id="modalBranchesContainer">
                        <!-- Dynamic Branch Cards rendered by JS -->
                    </div>

                    <!-- Flow Line Down -->
                    <div class="flex flex-col items-center text-slate-300">
                        <div class="w-[2px] h-6 bg-emerald-300"></div>
                        <i class="ph-bold ph-caret-down text-emerald-500 text-base -mt-1"></i>
                    </div>

                    <!-- Conclusion Synthesis Node -->
                    <div class="p-5 bg-emerald-700 text-white rounded-2xl shadow-md border-2 border-emerald-600 text-center max-w-2xl mx-auto">
                        <div class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-200 mb-1">Intisari Konseptual</div>
                        <h4 class="text-sm sm:text-base font-bold" id="modalConclusionText">
                            🏆 Retensi Memori & Pemahaman Maksimal Melalui Siklus Belajar Aktif
                        </h4>
                    </div>

                </div>

            </div>

            <!-- Modal Footer -->
            <div class="p-3.5 sm:p-4 border-t border-slate-100 bg-white flex items-center justify-between shrink-0">
                <div class="text-xs text-slate-500 flex items-center gap-1.5">
                    <i class="ph-fill ph-info text-indigo-600"></i>
                    <span>Eksplorasi peta konsep memperkuat koneksi pemahaman antartopik</span>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="claimConceptExp()" id="btnClaimConceptExp" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-sm flex items-center gap-1.5 transition-all hover:scale-105">
                        <i class="ph-bold ph-sparkle text-sm"></i>
                        <span>Tandai Paham (+30 EXP)</span>
                    </button>
                    <button onclick="closeConceptMapModal()" class="px-4 py-2 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-xs font-bold text-slate-700 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- ========================================================
         LEVEL & EXP TIERS MODAL (GAMIFICATION ROADMAP)
         ======================================================== -->
    <div id="levelUpModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-3 sm:p-4 opacity-0 pointer-events-none transition-all duration-300">
        <div class="clean-card max-w-lg w-full max-h-[92vh] flex flex-col bg-white transform scale-95 transition-all duration-300 shadow-2xl rounded-3xl border border-slate-200 overflow-hidden" id="levelUpModalCard">
            
            <!-- Modal Header -->
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70 shrink-0">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 border border-amber-200 flex items-center justify-center text-amber-600 text-lg shadow-xs">
                        <i class="ph-fill ph-trophy"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-sm sm:text-base text-slate-900 leading-tight" id="modalLevelMainTitle">Tingkatan Level & Status Belajar</h3>
                        <p class="text-[11px] text-slate-500 font-medium">Jalur pencapaian EXP dan gelar pembelajar Anda</p>
                    </div>
                </div>
                <button onclick="closeLevelUpModal()" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 flex items-center justify-center transition-colors" title="Tutup Modal">
                    <i class="ph-bold ph-x text-base"></i>
                </button>
            </div>

            <!-- Modal Scrollable Body -->
            <div class="p-4 sm:p-5 overflow-y-auto space-y-4 text-left custom-scrollbar">

                <!-- Celebration Alert (Tampil khusus saat event Level Up) -->
                <div id="modalLevelUpCelebration" class="hidden p-3.5 bg-gradient-to-r from-amber-500 via-indigo-600 to-purple-600 rounded-2xl text-white shadow-md text-center space-y-1">
                    <span class="inline-block bg-white/20 text-white text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                        🎉 SELAMAT! LEVEL UP!
                    </span>
                    <h4 class="font-black text-base sm:text-lg text-white" id="modalLevelUpCelebrationTitle">Pangkat Baru Berhasil Diraih!</h4>
                    <p class="text-xs text-white/90" id="modalLevelUpCelebrationDesc">Pengalaman dan ketekunan belajar Anda telah membuka tingkat berikutnya.</p>
                </div>

                <!-- Current Level Status Hero Card -->
                <div class="bg-gradient-to-br from-indigo-50/80 via-white to-slate-50 border border-indigo-100 rounded-2xl p-4 shadow-xs space-y-3">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-2xl shadow-sm shrink-0" id="modalCurrentLevelIconContainer">
                                <i class="ph-fill ph-seedling" id="modalCurrentLevelIcon"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <span class="bg-indigo-600 text-white text-[10px] font-black px-2 py-0.2 rounded-md uppercase" id="modalCurrentLevelBadge">LEVEL 1</span>
                                    <span class="text-xs font-bold text-slate-500" id="modalCurrentStreakText">🔥 1 Hari Streak</span>
                                </div>
                                <h4 class="font-extrabold text-base text-slate-900 mt-0.5" id="modalCurrentRankTitle">Pelajar Pemula</h4>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="text-[10px] text-slate-400 font-bold uppercase">Total EXP Anda</div>
                            <div class="text-lg font-black text-indigo-600 leading-none" id="modalCurrentTotalExp">100 XP</div>
                        </div>
                    </div>

                    <!-- Progress Bar to Next Level -->
                    <div class="space-y-1.5 pt-2 border-t border-indigo-100/60">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-slate-600" id="modalCurrentProgressLabel">Progress Menuju Tingkat Selanjutnya</span>
                            <span class="text-indigo-600" id="modalCurrentProgressPercent">50%</span>
                        </div>
                        <div class="w-full h-2.5 bg-slate-200/80 rounded-full overflow-hidden p-0.5 border border-slate-200">
                            <div class="h-full bg-gradient-to-r from-emerald-500 to-indigo-600 rounded-full transition-all duration-500" id="modalCurrentProgressBar" style="width: 50%"></div>
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-slate-500 font-medium">
                            <span id="modalCurrentExpRatio">100 / 200 XP</span>
                            <span class="text-indigo-700 font-bold" id="modalCurrentRemainingText">100 XP lagi menuju Level 2</span>
                        </div>
                    </div>
                </div>

                <!-- Section: Tingkatan Level Gamifikasi -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-extrabold text-xs text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="ph-bold ph-stairs text-indigo-600"></i> Tingkatan Level Belajar
                        </h4>
                        <span class="text-[11px] text-slate-400 font-medium">6 Tingkatan Tersedia</span>
                    </div>

                    <!-- Container for Level Tiers -->
                    <div class="space-y-2" id="modalLevelTiersList">
                        <!-- Tiers di-generate secara dinamis oleh JavaScript -->
                    </div>
                </div>

                <!-- Cara Mendapatkan EXP Info Box -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-3.5 space-y-2">
                    <h5 class="text-[11px] font-bold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="ph-bold ph-lightning text-amber-500"></i> Cara Memperoleh EXP:
                    </h5>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-[11px]">
                        <div class="p-2 bg-white rounded-xl border border-slate-200 flex items-center justify-between">
                            <span class="text-slate-600">Kuis Soal Benar</span>
                            <span class="font-extrabold text-amber-600">+20 XP</span>
                        </div>
                        <div class="p-2 bg-white rounded-xl border border-slate-200 flex items-center justify-between">
                            <span class="text-slate-600">Kuasai Flashcard</span>
                            <span class="font-extrabold text-indigo-600">+15 XP</span>
                        </div>
                        <div class="p-2 bg-white rounded-xl border border-slate-200 flex items-center justify-between">
                            <span class="text-slate-600">Eksplor Peta Konsep</span>
                            <span class="font-extrabold text-emerald-600">+30 XP</span>
                        </div>
                        <div class="p-2 bg-white rounded-xl border border-slate-200 flex items-center justify-between">
                            <span class="text-slate-600">Diskusi Tanya AI</span>
                            <span class="font-extrabold text-purple-600">+10 XP</span>
                        </div>
                        <div class="p-2 bg-white rounded-xl border border-slate-200 flex items-center justify-between">
                            <span class="text-slate-600">Tambah Dokumen</span>
                            <span class="font-extrabold text-blue-600">+50 XP</span>
                        </div>
                        <div class="p-2 bg-white rounded-xl border border-slate-200 flex items-center justify-between">
                            <span class="text-slate-600">Kuis Nilai 100</span>
                            <span class="font-extrabold text-rose-600">+150 XP</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="p-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end shrink-0">
                <button onclick="closeLevelUpModal()" class="w-full sm:w-auto px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-sm transition-all hover:scale-[1.01]">
                    Tutup & Lanjut Belajar
                </button>
            </div>

        </div>
    </div>

    <!-- Floating XP Toast Container -->
    <div id="xpToastContainer" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- ========================================================
         SCRIPTS & GAMIFICATION LOGIC
         ======================================================== -->
    <script>
        // --- 1. GAMIFICATION STATE & ENGINE ---
        let userExp = {{ Auth::check() ? Auth::user()->exp : (isset($user) && $user ? $user->exp : 450) }};
        let userStreak = {{ Auth::check() ? Auth::user()->streak : (isset($user) && $user ? $user->streak : 5) }};
        let conceptExplored = localStorage.getItem('loma_concept_explored') === 'true';
        let answeredQuestions = {}; // tracks { qIdx: selectedOptIdx }
        let isQuizSubmitted = false;
        let currentQuizIndex = 0;
        let quizViewMode = 'single'; // 'single' or 'all'
        let conceptZoomLevel = 1.0;

        const LEVEL_THRESHOLDS = [
            { level: 1, min: 0, max: 200, title: "Pelajar Pemula", icon: "ph-seedling" },
            { level: 2, min: 200, max: 500, title: "Penjelajah Konsep", icon: "ph-compass" },
            { level: 3, min: 500, max: 900, title: "Pelajar Tangguh", icon: "ph-trophy" },
            { level: 4, min: 900, max: 1400, title: "Cendekiawan Digital", icon: "ph-graduation-cap" },
            { level: 5, min: 1400, max: 2000, title: "Master Pengetahuan", icon: "ph-crown" },
            { level: 6, min: 2000, max: 2800, title: "Grandmaster Belajar", icon: "ph-sparkle" }
        ];

        function getLevelInfo(exp) {
            for (let i = LEVEL_THRESHOLDS.length - 1; i >= 0; i--) {
                if (exp >= LEVEL_THRESHOLDS[i].min) {
                    const currentLvl = LEVEL_THRESHOLDS[i];
                    const nextLvl = LEVEL_THRESHOLDS[i + 1] || { min: currentLvl.max, max: currentLvl.max + 1000, title: "Legenda" };
                    const range = nextLvl.min - currentLvl.min;
                    const progress = Math.min(100, Math.max(0, Math.round(((exp - currentLvl.min) / range) * 100)));
                    return {
                        level: currentLvl.level,
                        title: currentLvl.title,
                        icon: currentLvl.icon,
                        min: currentLvl.min,
                        nextMin: nextLvl.min,
                        progress: progress
                    };
                }
            }
            return { level: 1, title: "Pelajar Pemula", icon: "ph-seedling", min: 0, nextMin: 200, progress: 0 };
        }

        function updateGamificationUI() {
            const info = getLevelInfo(userExp);
            
            // Navbar elements
            const expBadge = document.getElementById('userExpBadge');
            const levelBadge = document.getElementById('userLevelBadge');
            const progressBar = document.getElementById('userExpProgressBar');
            const streakBadge = document.getElementById('userStreakBadge');

            if (expBadge) expBadge.innerText = `${userExp} XP`;
            if (levelBadge) levelBadge.innerText = `LEVEL ${info.level}`;
            if (progressBar) progressBar.style.width = `${info.progress}%`;
            if (streakBadge) streakBadge.innerText = `${userStreak} Hari Streak`;

            // Studio Hub elements
            const hubExp = document.getElementById('hubExpText');
            const hubRank = document.getElementById('userRankTitle');
            const hubProgress = document.getElementById('hubProgressText');
            const hubBar = document.getElementById('hubProgressBar');

            if (hubExp) hubExp.innerText = `${userExp} XP`;
            if (hubRank) hubRank.innerText = `${info.title} • Level ${info.level}`;
            if (hubProgress) hubProgress.innerText = `${info.progress}% menuju Level ${info.level + 1}`;
            if (hubBar) hubBar.style.width = `${info.progress}%`;
        }

        function addExp(amount, reason = '') {
            if (amount <= 0) return;
            const oldInfo = getLevelInfo(userExp);
            userExp += amount;
            localStorage.setItem('loma_user_exp', userExp);
            const newInfo = getLevelInfo(userExp);

            updateGamificationUI();
            showExpToast(amount, reason);
            playExpChime();

            // Trigger Level Up Celebration if level crossed
            if (newInfo.level > oldInfo.level) {
                triggerLevelUp(newInfo);
            }

            // Sync with MySQL Database
            @if(Auth::check())
            fetch("{{ route('api.update-exp') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({ amount: amount, reason: reason })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('EXP berhasil disimpan ke database:', data);
                }
            })
            .catch(err => console.warn('Gagal sinkronisasi ke database:', err));
            @endif
        }

        function showExpToast(amount, reason) {
            const container = document.getElementById('xpToastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'bg-slate-900 text-white border border-amber-400/40 shadow-2xl rounded-2xl p-3 sm:p-3.5 flex items-center gap-3 transform translate-y-4 opacity-0 transition-all duration-300 pointer-events-auto';
            toast.innerHTML = `
                <div class="w-9 h-9 rounded-xl bg-amber-400 text-slate-900 flex items-center justify-center font-black text-base shrink-0 shadow-sm animate-bounce">
                    <i class="ph-fill ph-star"></i>
                </div>
                <div class="flex flex-col">
                    <div class="font-black text-amber-300 text-sm tracking-wide">+${amount} EXP Diterima!</div>
                    <div class="text-[11px] text-slate-300 font-medium">${escapeHtml(reason || 'Aktivitas Belajar')}</div>
                </div>
            `;
            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-4', 'opacity-0');
            });

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-x-6');
                setTimeout(() => toast.remove(), 350);
            }, 3000);
        }

        function playExpChime() {
            try {
                const AudioContext = window.AudioContext || window.webkitAudioContext;
                if (!AudioContext) return;
                const ctx = new AudioContext();
                const now = ctx.currentTime;
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();

                osc.type = 'sine';
                osc.frequency.setValueAtTime(523.25, now); // C5
                osc.frequency.setValueAtTime(659.25, now + 0.08); // E5
                osc.frequency.setValueAtTime(783.99, now + 0.16); // G5

                gain.gain.setValueAtTime(0.12, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.4);

                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start(now);
                osc.stop(now + 0.4);
            } catch (e) {}
        }

        function triggerLevelUp(info) {
            playExpChime();
            openLevelUpModal(true);
        }

        // --- 2. DATA SOURCES & LEARNING CONTENT (CLEAN REAL-TIME STATE) ---
        let currentSources = [];
        let flashcardsData = [];
        let currentFlashcardIdx = 0;
        let currentConceptMap = null;
        let currentQuizData = [];

        let activeModalTab = 'file';

        function getActiveSourcesContext() {
            return currentSources
                .filter(s => s.checked)
                .map(s => `[Sumber: ${s.title}]\n${s.fullText || s.desc}`)
                .join("\n\n");
        }

        // --- Rename Module Title ---
        function renameModule() {
            const current = document.getElementById('moduleTitle').innerText;
            const newTitle = prompt('Masukkan nama modul belajar:', current);
            if (newTitle && newTitle.trim()) {
                document.getElementById('moduleTitle').innerText = newTitle.trim();
                const container = document.getElementById('moduleTitleContainer');
                if (container) container.title = newTitle.trim();
            }
        }

        // --- Center Panel Tab Switcher ---
        function switchCenterTab(tab) {
            const summaryView = document.getElementById('centerContent-summary');
            const chatView = document.getElementById('centerContent-chat');
            const copyBtn = document.getElementById('centerCopyBtn');
            const clearChatBtn = document.getElementById('centerClearChatBtn');
            const tabSum = document.getElementById('cTab-summary');
            const tabChat = document.getElementById('cTab-chat');

            if (tab === 'summary') {
                if (summaryView) summaryView.classList.remove('hidden');
                if (chatView) chatView.classList.add('hidden');
                if (copyBtn) copyBtn.classList.remove('hidden');
                if (clearChatBtn) clearChatBtn.classList.add('hidden');

                if (tabSum) tabSum.className = "center-tab-btn py-1.5 px-3.5 rounded-lg text-xs font-bold bg-white text-indigo-700 shadow-sm border border-slate-200/70 flex items-center gap-1.5 transition-all";
                if (tabChat) tabChat.className = "center-tab-btn py-1.5 px-3.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 transition-all";
            } else {
                if (summaryView) summaryView.classList.add('hidden');
                if (chatView) chatView.classList.remove('hidden');
                if (copyBtn) copyBtn.classList.add('hidden');
                if (clearChatBtn) clearChatBtn.classList.remove('hidden');

                if (tabChat) tabChat.className = "center-tab-btn py-1.5 px-3.5 rounded-lg text-xs font-bold bg-white text-indigo-700 shadow-sm border border-slate-200/70 flex items-center gap-1.5 transition-all";
                if (tabSum) tabSum.className = "center-tab-btn py-1.5 px-3.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 transition-all";
                
                const stream = document.getElementById('chatStream');
                if (stream) stream.scrollTop = stream.scrollHeight;
            }
        }

        function handleQuickSummaryKeydown(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                handleQuickSummarySubmit();
            }
        }

        function handleQuickSummarySubmit() {
            const input = document.getElementById('quickSummaryQuestion');
            if (!input) return;
            const val = input.value.trim();
            if (!val) return;
            input.value = '';
            
            switchCenterTab('chat');
            const chatInput = document.getElementById('chatInput');
            if (chatInput) {
                chatInput.value = val;
                handleSendChat(new Event('submit'));
            }
        }

        // --- Mobile View Switcher ---
        function switchMobileView(view) {
            const pSources = document.getElementById('panelSources');
            const pCenter = document.getElementById('panelCenter');
            const pStudio = document.getElementById('panelStudio');

            if (pSources) pSources.classList.add('hidden');
            if (pCenter) pCenter.classList.add('hidden');
            if (pStudio) pStudio.classList.add('hidden');

            document.querySelectorAll('[id^="mTab-"]').forEach(btn => {
                btn.className = "px-3 py-1 rounded-lg text-xs font-semibold text-slate-600 shrink-0";
            });

            const activeBtn = document.getElementById(`mTab-${view}`);
            if (activeBtn) {
                activeBtn.className = "px-3 py-1 rounded-lg text-xs font-bold bg-white text-indigo-700 border border-slate-200 shadow-sm shrink-0";
            }

            if (view === 'sources' && pSources) pSources.classList.remove('hidden');
            if (view === 'summary' && pCenter) {
                pCenter.classList.remove('hidden');
                switchCenterTab('summary');
            }
            if (view === 'chat' && pCenter) {
                pCenter.classList.remove('hidden');
                switchCenterTab('chat');
            }
            if (view === 'studio' && pStudio) pStudio.classList.remove('hidden');
        }

        // --- Sources Management ---
        function toggleSelectAllSources(checked) {
            currentSources.forEach(s => s.checked = checked);
            document.querySelectorAll('.source-checkbox').forEach(cb => cb.checked = checked);
            updateSourcesCount();
        }

        function toggleSourceCheck(index) {
            if (currentSources[index]) {
                currentSources[index].checked = !currentSources[index].checked;
                const checkboxes = document.querySelectorAll('.source-checkbox');
                if (checkboxes[index]) checkboxes[index].checked = currentSources[index].checked;
                updateSourcesCount();
            }
        }

        function deleteSource(e, index) {
            e.stopPropagation();
            if (confirm('Hapus dokumen ini dari daftar sumber?')) {
                currentSources.splice(index, 1);
                renderSourcesList();
            }
        }

        function updateSourcesCount() {
            const activeCount = currentSources.filter(s => s.checked).length;
            const headerEl = document.getElementById('headerSourceCount');
            const mCountEl = document.getElementById('mCount');
            const badgeEl = document.getElementById('sourcesCounterBadge');
            if (headerEl) headerEl.innerText = `${activeCount} Sumber Aktif`;
            if (mCountEl) mCountEl.innerText = activeCount;
            if (badgeEl) badgeEl.innerText = `${activeCount} / 10`;

            const sumEmpty = document.getElementById('summaryEmptyState');
            const sumCard = document.getElementById('summaryHeroCard');
            if (sumEmpty && sumCard) {
                if (currentSources.length === 0) {
                    sumEmpty.classList.remove('hidden');
                    sumCard.classList.add('hidden');
                } else {
                    sumEmpty.classList.add('hidden');
                    sumCard.classList.remove('hidden');
                }
            }

            const qCountEl = document.getElementById('studioQuizCount');
            const cCountEl = document.getElementById('studioCardCount');
            const bCountEl = document.getElementById('studioBranchesCount');
            if (qCountEl) qCountEl.innerText = `${currentQuizData.length} Soal Tersedia`;
            if (cCountEl) cCountEl.innerText = `${flashcardsData.length} Kartu Aktif`;
            if (bCountEl) bCountEl.innerText = `${currentConceptMap && currentConceptMap.cabang ? currentConceptMap.cabang.length : 0} Cabang Konsep`;
        }

        function renderSourcesList() {
            const container = document.getElementById('sourcesListContainer');
            if (!container) return;

            if (currentSources.length === 0) {
                container.innerHTML = `
                    <div id="sourcesEmptyState" class="my-auto py-8 px-4 text-center flex flex-col items-center justify-center">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-xl mb-3">
                            <i class="ph-bold ph-files"></i>
                        </div>
                        <h4 class="font-bold text-xs text-slate-800 mb-1">Belum Ada Dokumen</h4>
                        <p class="text-[11px] text-slate-500 max-w-[200px] leading-relaxed mb-4">Tambahkan file PDF, DOCX, TXT atau artikel website untuk mulai belajar.</p>
                        <button onclick="openSourceModal()" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold shadow-xs flex items-center gap-1.5 transition-colors">
                            <i class="ph-bold ph-plus"></i>
                            <span>Tambah Sumber</span>
                        </button>
                    </div>
                `;
                updateSourcesCount();
                return;
            }

            container.innerHTML = '';
            currentSources.forEach((src, idx) => {
                const colorBadge = src.type === 'PDF' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' :
                                   src.type === 'URL' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' :
                                   src.type === 'DOCX' ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-slate-100 text-slate-700 border-slate-200';
                container.innerHTML += `
                    <div class="source-item p-2.5 bg-white rounded-xl border border-slate-200 hover:border-indigo-400 hover:shadow-sm transition-all flex items-start gap-2.5 group relative cursor-pointer" onclick="toggleSourceCheck(${idx})">
                        <input type="checkbox" ${src.checked ? 'checked' : ''} class="accent-indigo-600 w-3.5 h-3.5 mt-0.5 rounded cursor-pointer source-checkbox" onclick="event.stopPropagation()">
                        <div class="flex-grow min-w-0">
                            <div class="flex items-center gap-1.5 mb-0.5">
                                <span class="${colorBadge} border text-[9px] font-bold px-1.5 py-0.2 rounded">${src.type}</span>
                                <span class="text-xs font-bold text-slate-800 truncate">${src.title}</span>
                            </div>
                            <p class="text-[11px] text-slate-500 line-clamp-2 leading-tight">${src.desc}</p>
                        </div>
                        <button class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-rose-600 transition-opacity text-xs p-1" onclick="deleteSource(event, ${idx})" title="Hapus">
                            <i class="ph-bold ph-trash"></i>
                        </button>
                    </div>
                `;
            });
            updateSourcesCount();
        }

        // --- Chat Stream Logic ---
        function handleTextareaKeydown(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                handleSendChat(e);
            }
        }

        function sendQuickPrompt(promptText) {
            document.getElementById('chatInput').value = promptText;
            handleSendChat(new Event('submit'));
        }

        function handleSendChat(e) {
            e.preventDefault();
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            if (!message) return;

            appendUserMessage(message);
            input.value = '';

            // Award small EXP for active inquiry
            addExp(10, 'Pertanyaan Diskusi AI');

            showTypingIndicator();
            generateAiAnswer(message);
        }

        function appendUserMessage(text) {
            const stream = document.getElementById('chatStream');
            const userHtml = `
                <div class="flex items-start justify-end gap-2.5">
                    <div class="max-w-[85%] bg-indigo-600 text-white rounded-2xl rounded-tr-sm p-3 shadow-sm text-xs sm:text-sm font-medium">
                        <p>${escapeHtml(text)}</p>
                    </div>
                    <div class="w-7 h-7 rounded-full bg-slate-800 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                        Anda
                    </div>
                </div>
            `;
            stream.innerHTML += userHtml;
            stream.scrollTop = stream.scrollHeight;
        }

        function showTypingIndicator() {
            const stream = document.getElementById('chatStream');
            const typingHtml = `
                <div id="aiTypingIndicator" class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold shrink-0">
                        AI
                    </div>
                    <div class="bg-white border border-slate-200 rounded-xl px-3 py-2 shadow-sm flex items-center gap-2">
                        <div class="clean-spinner"></div>
                        <span class="text-xs font-medium text-slate-500">Menganalisis dokumen sumber...</span>
                    </div>
                </div>
            `;
            stream.innerHTML += typingHtml;
            stream.scrollTop = stream.scrollHeight;
        }

        function removeTypingIndicator() {
            const el = document.getElementById('aiTypingIndicator');
            if (el) el.remove();
        }

        async function generateAiAnswer(userMsg) {
            const stream = document.getElementById('chatStream');
            const activeContext = getActiveSourcesContext();
            const activeSourcesList = currentSources.filter(s => s.checked).map(s => s.title);

            let answerHtml = '';

            try {
                const res = await fetch('{{ url("/api/chat-ai") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        message: userMsg,
                        context: activeContext,
                        sources: activeSourcesList
                    })
                });

                const data = await res.json();
                removeTypingIndicator();

                if (data.status === 'success') {
                    let raw = data.answer || '';
                    raw = raw.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                    raw = raw.replace(/\*(.*?)\*/g, '<em>$1</em>');
                    raw = raw.replace(/\[(\d+)\]/g, `<span class="inline-block bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-semibold px-1.5 py-0.2 rounded cursor-pointer hover:bg-indigo-600 hover:text-white" title="Sitasi Sumber [$1]">[$1]</span>`);
                    raw = raw.replace(/\n\n/g, '<br><br>').replace(/\n/g, '<br>');
                    answerHtml = raw;
                } else {
                    answerHtml = `Maaf, terjadi kendala saat memproses jawaban: ${escapeHtml(data.message || 'Gagal')}`;
                }
            } catch (err) {
                removeTypingIndicator();
                answerHtml = `Gagal terhubung ke model AI. Silakan periksa koneksi.`;
            }

            const aiHtml = `
                <div class="flex items-start gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold shrink-0 shadow-sm">
                        AI
                    </div>
                    <div class="max-w-[88%] bg-slate-50 border border-slate-200/90 rounded-2xl rounded-tl-sm p-3.5 shadow-sm text-xs sm:text-sm text-slate-800 leading-relaxed font-normal">
                        <div>${answerHtml}</div>
                        <div class="text-[10px] text-slate-400 pt-2 mt-2 border-t border-slate-200/80 flex items-center gap-1.5 font-medium">
                            <i class="ph-fill ph-check-circle text-emerald-500"></i> Divalidasi langsung dari dokumen terpilih
                        </div>
                    </div>
                </div>
            `;
            stream.innerHTML += aiHtml;
            stream.scrollTop = stream.scrollHeight;
        }

        function clearChatHistory() {
            if (confirm('Bersihkan percakapan chat?')) {
                document.getElementById('chatStream').innerHTML = `
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                        <h3 class="font-bold text-sm text-slate-800 mb-0.5">Chat Telah Dibersihkan</h3>
                        <p class="text-xs text-slate-500 font-normal">Tanyakan pertanyaan baru seputar dokumen aktif:</p>
                        <div class="mt-2.5 flex flex-wrap gap-1.5">
                            <button onclick="sendQuickPrompt('Ringkas materi ini')" class="px-2.5 py-1 bg-white hover:bg-slate-100 border border-slate-200 rounded-lg text-xs font-medium text-slate-700 shadow-sm transition-colors">💡 Ringkas materi</button>
                        </div>
                    </div>
                `;
            }
        }

        function copySummaryText() {
            navigator.clipboard.writeText(document.getElementById('summaryContainer').innerText);
            alert('Rangkuman materi berhasil disalin ke clipboard!');
        }

        // ========================================================
        // 3. POP-UP MODAL: KUIS TANTANGAN (15 SOAL KOMPREHENSIF)
        // ========================================================
        function getCorrectAnswerIndex(q) {
            if (!q) return 0;
            const jb = q.jawaban_benar;
            if (typeof jb === 'number') {
                if (jb >= 0 && jb < (q.opsi ? q.opsi.length : 4)) {
                    return jb;
                }
                if (jb >= 1 && jb <= (q.opsi ? q.opsi.length : 4)) {
                    return jb - 1;
                }
            }
            if (typeof jb === 'string') {
                const trimmed = jb.trim();
                if (/^[0-3]$/.test(trimmed)) {
                    return parseInt(trimmed, 10);
                }
                const letterMatch = trimmed.match(/^[A-Da-d]$/);
                if (letterMatch) {
                    return letterMatch[0].toUpperCase().charCodeAt(0) - 65;
                }
                const prefixMatch = trimmed.match(/^(?:opsi|option)?\s*([A-Da-d])[\.\:\s]/i);
                if (prefixMatch) {
                    return prefixMatch[1].toUpperCase().charCodeAt(0) - 65;
                }
                if (Array.isArray(q.opsi)) {
                    const exactIdx = q.opsi.findIndex(opt => opt && opt.trim().toLowerCase() === trimmed.toLowerCase());
                    if (exactIdx !== -1) return exactIdx;
                    const partialIdx = q.opsi.findIndex(opt => opt && (opt.toLowerCase().includes(trimmed.toLowerCase()) || trimmed.toLowerCase().includes(opt.toLowerCase())));
                    if (partialIdx !== -1) return partialIdx;
                }
            }
            return 0;
        }

        function updateQuizSubmitButton() {
            const btn = document.getElementById('quizSubmitBtn');
            if (!btn) return;
            if (isQuizSubmitted) {
                btn.innerHTML = `<i class="ph-bold ph-arrow-counter-clockwise text-base"></i><span>Ulangi Kuis</span>`;
                btn.className = "w-full sm:w-auto px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-300 flex items-center justify-center gap-2 transition-all shadow-xs";
                btn.onclick = resetQuiz;
            } else {
                btn.innerHTML = `<i class="ph-bold ph-check-circle text-base"></i><span>Cek Jawaban & Klaim EXP</span>`;
                btn.className = "w-full sm:w-auto px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-sm flex items-center justify-center gap-2 transition-all hover:scale-[1.02]";
                btn.onclick = submitQuizAnswers;
            }
        }

        function resetQuiz() {
            if (confirm('Ulangi latihan kuis ini dari awal? Jawaban Anda akan di-reset.')) {
                answeredQuestions = {};
                isQuizSubmitted = false;
                currentQuizIndex = 0;
                const resultBanner = document.getElementById('quizResultBanner');
                if (resultBanner) resultBanner.innerHTML = '';
                updateQuizSubmitButton();
                renderQuizModal();
            }
        }

        function openQuizModal() {
            if (!currentQuizData || currentQuizData.length === 0) {
                alert('Belum ada kuis yang tersedia. Silakan tambahkan dokumen sumber terlebih dahulu untuk mulai latihan kuis.');
                openSourceModal();
                return;
            }
            const m = document.getElementById('quizModal');
            const c = document.getElementById('quizModalCard');
            m.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                c.classList.remove('scale-95');
                c.classList.add('scale-100');
            }, 50);

            currentQuizIndex = 0;
            updateQuizSubmitButton();
            renderQuizModal();
        }

        function closeQuizModal() {
            const m = document.getElementById('quizModal');
            const c = document.getElementById('quizModalCard');
            c.classList.remove('scale-100');
            c.classList.add('scale-95');
            setTimeout(() => {
                m.classList.add('opacity-0', 'pointer-events-none');
            }, 200);
        }

        function toggleQuizViewMode() {
            quizViewMode = quizViewMode === 'single' ? 'all' : 'single';
            const toggleText = document.getElementById('quizViewToggleText');
            if (toggleText) {
                toggleText.innerText = quizViewMode === 'single' ? 'Tampilkan Semua Soal' : 'Tampilan Satu per Satu';
            }
            renderQuizModal();
        }

        function renderQuizModal() {
            const total = currentQuizData.length;
            const answeredTotal = Object.keys(answeredQuestions).length;
            const countContainer = document.getElementById('quizAnsweredCountContainer');

            // Render Navigation Pills
            const pillsContainer = document.getElementById('quizNavPills');
            pillsContainer.innerHTML = '';

            let correctCount = 0;
            if (isQuizSubmitted) {
                currentQuizData.forEach((q, idx) => {
                    const cIdx = getCorrectAnswerIndex(q);
                    if (answeredQuestions[idx] === cIdx) {
                        correctCount++;
                    }
                });
            }

            for (let i = 0; i < total; i++) {
                const isCurrent = i === currentQuizIndex;
                const isAnswered = answeredQuestions[i] !== undefined;

                let pillClass = "w-7 h-7 sm:w-8 sm:h-8 rounded-lg text-xs font-bold flex items-center justify-center cursor-pointer transition-all shrink-0 ";
                let titleAttr = `Soal ${i + 1}`;

                if (isQuizSubmitted) {
                    const q = currentQuizData[i];
                    const correctIdx = getCorrectAnswerIndex(q);
                    const userPick = answeredQuestions[i];
                    const isCorrect = userPick !== undefined && userPick === correctIdx;

                    if (isCorrect) {
                        pillClass += "bg-emerald-500 hover:bg-emerald-600 text-white font-black shadow-xs ";
                        titleAttr += " (Benar)";
                    } else {
                        pillClass += "bg-rose-500 hover:bg-rose-600 text-white font-black shadow-xs ";
                        titleAttr += " (Salah)";
                    }

                    if (isCurrent) {
                        pillClass += "ring-2 ring-offset-2 ring-indigo-600 scale-105 z-10 ";
                    }
                } else {
                    if (isCurrent) {
                        pillClass += "bg-indigo-600 text-white shadow-sm ring-2 ring-indigo-200 ";
                    } else if (isAnswered) {
                        pillClass += "bg-indigo-100 text-indigo-800 border border-indigo-200 font-semibold ";
                    } else {
                        pillClass += "bg-white text-slate-600 border border-slate-200 hover:border-slate-300 ";
                    }
                }

                pillsContainer.innerHTML += `
                    <button onclick="goToQuizQuestion(${i})" class="${pillClass}" title="${titleAttr}">
                        ${i + 1}
                    </button>
                `;
            }

            // Update Counter Header
            if (countContainer) {
                if (isQuizSubmitted) {
                    const wrongCount = total - correctCount;
                    countContainer.innerHTML = `
                        <div class="flex items-center gap-1.5 font-bold">
                            <span class="text-slate-500 text-[10px] hidden sm:inline">Hasil:</span>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] sm:text-xs font-extrabold flex items-center gap-1"><i class="ph-bold ph-check"></i> ${correctCount} Benar</span>
                            <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-800 text-[10px] sm:text-xs font-extrabold flex items-center gap-1"><i class="ph-bold ph-x"></i> ${wrongCount} Salah</span>
                        </div>
                    `;
                } else {
                    countContainer.innerHTML = `Dijawab: <span id="quizAnsweredCount" class="text-indigo-600 font-bold">${answeredTotal}</span>/<span id="quizTotalCount">${total}</span>`;
                }
            }

            const singleView = document.getElementById('quizSingleViewContainer');
            const allView = document.getElementById('quizAllViewContainer');

            if (quizViewMode === 'single') {
                singleView.classList.remove('hidden');
                allView.classList.add('hidden');
                renderSingleQuizQuestion();
            } else {
                singleView.classList.add('hidden');
                allView.classList.remove('hidden');
                renderAllQuizQuestions();
            }
        }

        function renderSingleQuizQuestion() {
            const q = currentQuizData[currentQuizIndex];
            if (!q) return;

            const correctIdx = getCorrectAnswerIndex(q);
            const selectedOpt = answeredQuestions[currentQuizIndex];
            const isAnswered = selectedOpt !== undefined;
            const isCorrect = isAnswered && selectedOpt === correctIdx;
            const letters = ['A', 'B', 'C', 'D'];

            // Header status badge
            const badgeEl = document.getElementById('quizCurrentIndexBadge');
            if (badgeEl) {
                if (isQuizSubmitted) {
                    if (isCorrect) {
                        badgeEl.className = "bg-emerald-50 text-emerald-800 border border-emerald-300 px-2.5 py-0.5 rounded-full font-bold flex items-center gap-1.5 shadow-xs text-xs";
                        badgeEl.innerHTML = `<i class="ph-bold ph-check-circle text-emerald-600 text-sm"></i> Soal ${currentQuizIndex + 1} dari ${currentQuizData.length} &bull; <span class="text-emerald-700 font-black">BENAR (+20 EXP)</span>`;
                    } else {
                        badgeEl.className = "bg-rose-50 text-rose-800 border border-rose-300 px-2.5 py-0.5 rounded-full font-bold flex items-center gap-1.5 shadow-xs text-xs";
                        badgeEl.innerHTML = `<i class="ph-bold ph-x-circle text-rose-600 text-sm"></i> Soal ${currentQuizIndex + 1} dari ${currentQuizData.length} &bull; <span class="text-rose-700 font-black">${isAnswered ? 'JAWABAN SALAH' : 'BELUM DIJAWAB'}</span>`;
                    }
                } else {
                    badgeEl.className = "bg-indigo-50 text-indigo-700 border border-indigo-100 px-2.5 py-0.5 rounded-full font-bold text-xs";
                    badgeEl.innerText = `Soal ${currentQuizIndex + 1} dari ${currentQuizData.length}`;
                }
            }

            document.getElementById('quizSingleQuestionText').innerText = q.pertanyaan;

            const optsContainer = document.getElementById('quizSingleOptionsContainer');
            optsContainer.innerHTML = '';

            (q.opsi || []).forEach((opt, optIdx) => {
                let optClass = "p-3 sm:p-3.5 rounded-xl border flex items-center gap-3 transition-all select-none ";
                let badgeHtml = "";
                let tagHtml = "";

                if (isQuizSubmitted) {
                    const isThisCorrect = optIdx === correctIdx;
                    const isThisSelected = selectedOpt === optIdx;

                    if (isThisCorrect) {
                        // Kunci jawaban benar (selalu hijau)
                        optClass += "bg-emerald-50/90 border-emerald-500 text-emerald-950 font-bold shadow-xs ring-1 ring-emerald-400 cursor-default";
                        badgeHtml = `<span class="w-7 h-7 rounded-lg bg-emerald-600 text-white text-xs font-black flex items-center justify-center shrink-0 shadow-xs"><i class="ph-bold ph-check text-sm"></i></span>`;
                        tagHtml = `<span class="ml-auto text-[11px] font-bold text-emerald-800 bg-emerald-100/90 border border-emerald-300 px-2.5 py-0.5 rounded-md flex items-center gap-1 shrink-0"><i class="ph-bold ph-check"></i> ${isThisSelected ? 'Jawaban Anda (Benar)' : 'Kunci Benar'}</span>`;
                    } else if (isThisSelected) {
                        // Pilihan user yang salah (merah)
                        optClass += "bg-rose-50/90 border-rose-400 text-rose-950 font-bold shadow-xs ring-1 ring-rose-400 cursor-default";
                        badgeHtml = `<span class="w-7 h-7 rounded-lg bg-rose-600 text-white text-xs font-black flex items-center justify-center shrink-0 shadow-xs"><i class="ph-bold ph-x text-sm"></i></span>`;
                        tagHtml = `<span class="ml-auto text-[11px] font-bold text-rose-800 bg-rose-100/90 border border-rose-300 px-2.5 py-0.5 rounded-md flex items-center gap-1 shrink-0"><i class="ph-bold ph-x"></i> Pilihan Anda (Salah)</span>`;
                    } else {
                        // Opsi netral lainnya
                        optClass += "bg-slate-50/60 border-slate-200 text-slate-400 opacity-60 cursor-default";
                        badgeHtml = `<span class="w-7 h-7 rounded-lg bg-slate-100 text-slate-400 border border-slate-200 text-xs font-bold flex items-center justify-center shrink-0">${letters[optIdx] || optIdx + 1}</span>`;
                    }

                    optsContainer.innerHTML += `
                        <div class="${optClass}">
                            ${badgeHtml}
                            <span class="text-xs sm:text-sm leading-relaxed">${escapeHtml(opt)}</span>
                            ${tagHtml}
                        </div>
                    `;
                } else {
                    const isSelected = selectedOpt === optIdx;
                    if (isSelected) {
                        optClass += "bg-indigo-50/80 border-indigo-600 text-indigo-950 font-bold shadow-xs cursor-pointer";
                        badgeHtml = `<span class="w-7 h-7 rounded-lg bg-indigo-600 text-white text-xs font-black flex items-center justify-center shrink-0">${letters[optIdx] || optIdx + 1}</span>`;
                    } else {
                        optClass += "bg-white hover:bg-slate-50 border-slate-200 hover:border-slate-300 text-slate-700 font-medium cursor-pointer";
                        badgeHtml = `<span class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold flex items-center justify-center shrink-0">${letters[optIdx] || optIdx + 1}</span>`;
                    }

                    optsContainer.innerHTML += `
                        <div onclick="selectQuizOption(${currentQuizIndex}, ${optIdx})" class="${optClass}">
                            ${badgeHtml}
                            <span class="text-xs sm:text-sm leading-relaxed">${escapeHtml(opt)}</span>
                        </div>
                    `;
                }
            });

            // Explanation Box: Pastikan selalu sinkron dengan soal yang sedang dilihat!
            const explBox = document.getElementById('quizSingleExplanationBox');
            if (explBox) {
                if (isQuizSubmitted) {
                    explBox.classList.remove('hidden');
                    explBox.className = `mt-4 p-4 rounded-xl text-xs font-medium border shadow-xs transition-all ${isCorrect ? 'bg-emerald-50 text-emerald-950 border-emerald-200' : 'bg-rose-50 text-rose-950 border-rose-200'}`;
                    
                    const correctOptText = (q.opsi && q.opsi[correctIdx] !== undefined) ? `${letters[correctIdx]}. ${escapeHtml(q.opsi[correctIdx])}` : '';
                    const penjelasanText = q.penjelasan ? escapeHtml(q.penjelasan) : 'Tidak ada penjelasan tambahan untuk soal ini.';

                    explBox.innerHTML = `
                        <div class="font-extrabold mb-1.5 flex items-center gap-1.5 text-sm ${isCorrect ? 'text-emerald-700' : 'text-rose-700'}">
                            <i class="ph-bold ${isCorrect ? 'ph-check-circle text-lg' : 'ph-x-circle text-lg'}"></i>
                            <span>${isCorrect ? 'Jawaban Anda Tepat (+20 EXP)!' : (isAnswered ? 'Jawaban Kurang Tepat' : 'Soal Ini Belum Dijawab')}</span>
                        </div>
                        ${!isCorrect ? `
                            <div class="mb-2.5 p-2.5 bg-white/90 rounded-lg border border-rose-200/90 text-slate-800">
                                <span class="font-bold text-rose-700">Kunci Jawaban yang Benar:</span>
                                <span class="font-extrabold text-emerald-700 ml-1">${correctOptText}</span>
                            </div>
                        ` : ''}
                        <div class="text-slate-700 leading-relaxed font-normal">
                            <span class="font-bold text-slate-900">Pembahasan:</span> ${penjelasanText}
                        </div>
                    `;
                } else {
                    explBox.classList.add('hidden');
                    explBox.innerHTML = '';
                }
            }

            // Update Previous & Next Buttons
            const prevBtn = document.getElementById('quizPrevBtn');
            const nextBtn = document.getElementById('quizNextBtn');
            if (prevBtn) prevBtn.disabled = currentQuizIndex === 0;
            if (nextBtn) nextBtn.disabled = currentQuizIndex === currentQuizData.length - 1;
        }

        function renderAllQuizQuestions() {
            const container = document.getElementById('quizAllViewContainer');
            container.innerHTML = '';
            const letters = ['A', 'B', 'C', 'D'];

            currentQuizData.forEach((q, qIdx) => {
                const correctIdx = getCorrectAnswerIndex(q);
                const selectedOpt = answeredQuestions[qIdx];
                const isAnswered = selectedOpt !== undefined;
                const isCorrect = isAnswered && selectedOpt === correctIdx;

                let optsHtml = '';

                (q.opsi || []).forEach((opt, optIdx) => {
                    if (isQuizSubmitted) {
                        const isCorrectOpt = optIdx === correctIdx;
                        const isUserPick = selectedOpt === optIdx;
                        let optClass = "p-3 rounded-xl border flex items-center gap-2.5 transition-all text-xs ";
                        let badgeHtml = "";
                        let rightTagHtml = "";

                        if (isCorrectOpt) {
                            optClass += "bg-emerald-50 border-emerald-500 text-emerald-950 font-bold ring-1 ring-emerald-400";
                            badgeHtml = `<span class="w-6 h-6 rounded-md bg-emerald-600 text-white font-bold flex items-center justify-center shrink-0"><i class="ph-bold ph-check text-xs"></i></span>`;
                            rightTagHtml = `<span class="ml-auto text-[10px] font-bold text-emerald-700 bg-emerald-100 px-1.5 py-0.5 rounded flex items-center gap-1 shrink-0"><i class="ph-bold ph-check"></i> ${isUserPick ? 'Jawaban Anda' : 'Kunci Benar'}</span>`;
                        } else if (isUserPick) {
                            optClass += "bg-rose-50 border-rose-400 text-rose-950 font-bold ring-1 ring-rose-400";
                            badgeHtml = `<span class="w-6 h-6 rounded-md bg-rose-600 text-white font-bold flex items-center justify-center shrink-0"><i class="ph-bold ph-x text-xs"></i></span>`;
                            rightTagHtml = `<span class="ml-auto text-[10px] font-bold text-rose-700 bg-rose-100 px-1.5 py-0.5 rounded flex items-center gap-1 shrink-0"><i class="ph-bold ph-x"></i> Pilihan Anda (Salah)</span>`;
                        } else {
                            optClass += "bg-slate-50/50 border-slate-200 text-slate-400 opacity-60";
                            badgeHtml = `<span class="w-6 h-6 rounded-md bg-slate-100 text-slate-500 font-bold flex items-center justify-center shrink-0">${letters[optIdx]}</span>`;
                        }

                        optsHtml += `
                            <div class="${optClass}">
                                ${badgeHtml}
                                <span class="leading-relaxed">${escapeHtml(opt)}</span>
                                ${rightTagHtml}
                            </div>
                        `;
                    } else {
                        const isSelected = selectedOpt === optIdx;
                        optsHtml += `
                            <div onclick="selectQuizOption(${qIdx}, ${optIdx})" class="p-3 rounded-xl border flex items-center gap-2.5 cursor-pointer transition-all ${isSelected ? 'bg-indigo-50 border-indigo-600 text-indigo-900 font-bold' : 'bg-white hover:bg-slate-50 border-slate-200 text-slate-700 font-medium'}">
                                <span class="w-6 h-6 rounded-md ${isSelected ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600'} text-xs font-bold flex items-center justify-center shrink-0">
                                    ${letters[optIdx]}
                                </span>
                                <span class="text-xs">${escapeHtml(opt)}</span>
                            </div>
                        `;
                    }
                });

                let cardBorderClass = "border-slate-200";
                let statusBadgeHtml = `<span class="text-amber-600 font-bold">+20 EXP</span>`;

                if (isQuizSubmitted) {
                    if (isCorrect) {
                        cardBorderClass = "border-emerald-300 ring-1 ring-emerald-200";
                        statusBadgeHtml = `<span class="text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full font-bold flex items-center gap-1"><i class="ph-bold ph-check-circle"></i> Benar (+20 EXP)</span>`;
                    } else {
                        cardBorderClass = "border-rose-300 ring-1 ring-rose-200";
                        statusBadgeHtml = `<span class="text-rose-700 bg-rose-50 border border-rose-200 px-2 py-0.5 rounded-full font-bold flex items-center gap-1"><i class="ph-bold ph-x-circle"></i> Salah</span>`;
                    }
                }

                let explHtml = '';
                if (isQuizSubmitted) {
                    const correctOptText = (q.opsi && q.opsi[correctIdx] !== undefined) ? `${letters[correctIdx]}. ${escapeHtml(q.opsi[correctIdx])}` : '';
                    explHtml = `
                        <div class="mt-3 p-3 rounded-xl text-xs ${isCorrect ? 'bg-emerald-50/70 border border-emerald-200 text-emerald-950' : 'bg-rose-50/70 border border-rose-200 text-rose-950'}">
                            ${!isCorrect ? `<div class="mb-1.5"><span class="font-bold text-rose-700">Kunci Benar:</span> <span class="font-extrabold text-emerald-800 ml-1">${correctOptText}</span></div>` : ''}
                            <div class="text-slate-700 leading-relaxed font-normal"><span class="font-bold text-slate-800">Pembahasan:</span> ${escapeHtml(q.penjelasan || 'Tidak ada pembahasan')}</div>
                        </div>
                    `;
                }

                container.innerHTML += `
                    <div class="bg-white border ${cardBorderClass} rounded-2xl p-4 sm:p-5 shadow-xs space-y-3">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-500">
                            <span class="bg-slate-100 text-slate-700 px-2.5 py-0.5 rounded-full">Soal ${qIdx + 1}</span>
                            ${statusBadgeHtml}
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm">${escapeHtml(q.pertanyaan)}</h4>
                        <div class="space-y-2">
                            ${optsHtml}
                        </div>
                        ${explHtml}
                    </div>
                `;
            });
        }

        function selectQuizOption(qIdx, optIdx) {
            if (isQuizSubmitted) return; // Kunci pilihan setelah kuis dikumpulkan
            answeredQuestions[qIdx] = optIdx;
            renderQuizModal();
        }

        function goToQuizQuestion(idx) {
            currentQuizIndex = idx;
            renderQuizModal();
        }

        function prevQuizQuestion() {
            if (currentQuizIndex > 0) {
                currentQuizIndex--;
                renderQuizModal();
            }
        }

        function nextQuizQuestion() {
            if (currentQuizIndex < currentQuizData.length - 1) {
                currentQuizIndex++;
                renderQuizModal();
            }
        }

        function submitQuizAnswers() {
            if (isQuizSubmitted) return;
            const total = currentQuizData.length;
            const answeredCount = Object.keys(answeredQuestions).length;

            if (answeredCount < total) {
                if (!confirm(`Anda baru menjawab ${answeredCount} dari ${total} soal. Yakin ingin mengumpulkan sekarang?`)) {
                    return;
                }
            }

            let score = 0;
            currentQuizData.forEach((q, idx) => {
                const correctIdx = getCorrectAnswerIndex(q);
                if (answeredQuestions[idx] === correctIdx) {
                    score++;
                }
            });

            // Calculate EXP
            const earnedExp = score * 20;
            const bonusPerfect = (score === total) ? 150 : 0;
            const totalEarned = earnedExp + bonusPerfect;

            // Mark Quest Completed
            const questKuis = document.getElementById('questCheckKuis');
            if (questKuis) questKuis.className = "ph-fill ph-check-circle text-emerald-400";

            // Add EXP to User Account Live
            addExp(totalEarned, `Kuis Active Recall (${score}/${total} Benar)`);

            isQuizSubmitted = true;

            const resultBanner = document.getElementById('quizResultBanner');
            if (resultBanner) {
                resultBanner.innerHTML = `<span class="text-emerald-600 font-extrabold">Skor: ${score}/${total}</span> (${earnedExp} EXP${bonusPerfect ? ' + 150 Bonus Sempurna!' : ''})`;
            }

            updateQuizSubmitButton();
            renderQuizModal();

            alert(`Selesai! Anda berhasil menjawab benar ${score} dari ${total} soal.\nTotal reward diperoleh: +${totalEarned} EXP!`);
        }

        // ========================================================
        // 4. POP-UP MODAL: FLASHCARD ACTIVE RECALL
        // ========================================================
        function openFlashcardModal() {
            if (!flashcardsData || flashcardsData.length === 0) {
                alert('Belum ada flashcard yang tersedia. Silakan tambahkan dokumen sumber terlebih dahulu.');
                openSourceModal();
                return;
            }
            const m = document.getElementById('flashcardModal');
            const c = document.getElementById('flashcardModalCard');
            m.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                c.classList.remove('scale-95');
                c.classList.add('scale-100');
            }, 50);

            currentFlashcardIdx = 0;
            renderFlashcardModal();
        }

        function closeFlashcardModal() {
            const m = document.getElementById('flashcardModal');
            const c = document.getElementById('flashcardModalCard');
            c.classList.remove('scale-100');
            c.classList.add('scale-95');
            setTimeout(() => {
                m.classList.add('opacity-0', 'pointer-events-none');
            }, 200);
        }

        function renderFlashcardModal() {
            if (!flashcardsData || flashcardsData.length === 0) return;
            const total = flashcardsData.length;
            const card = flashcardsData[currentFlashcardIdx];

            document.getElementById('fcModalCounter').innerText = `${currentFlashcardIdx + 1} / ${total}`;
            document.getElementById('fcModalCounterBack').innerText = `${currentFlashcardIdx + 1} / ${total}`;
            document.getElementById('fcModalFrontText').innerText = card.front;
            document.getElementById('fcModalBackText').innerText = card.back;

            // Reset Flip State
            const cardEl = document.getElementById('flashcardModalFlippable');
            if (cardEl) cardEl.classList.remove('rotate-y-180');

            // Update Progress Bar
            const prog = Math.round(((currentFlashcardIdx + 1) / total) * 100);
            const pBar = document.getElementById('fcProgressBar');
            if (pBar) pBar.style.width = `${prog}%`;
        }

        function flipFlashcard() {
            const cardEl = document.getElementById('flashcardModalFlippable');
            if (cardEl) cardEl.classList.toggle('rotate-y-180');
        }

        function prevFlashcard() {
            if (currentFlashcardIdx > 0) {
                currentFlashcardIdx--;
                renderFlashcardModal();
            }
        }

        function nextFlashcard() {
            if (currentFlashcardIdx < flashcardsData.length - 1) {
                currentFlashcardIdx++;
                renderFlashcardModal();
            }
        }

        function markFlashcardMastered(mastered) {
            if (mastered) {
                addExp(15, `Kuasai Flashcard #${currentFlashcardIdx + 1}`);
                const questCard = document.getElementById('questCheckCard');
                if (questCard) questCard.className = "ph-fill ph-check-circle text-emerald-400";
            }
            if (currentFlashcardIdx < flashcardsData.length - 1) {
                currentFlashcardIdx++;
                renderFlashcardModal();
            } else {
                alert('Luar biasa! Anda telah menyelesaikan seluruh kartu pintar dalam set ini.');
            }
        }

        // ========================================================
        // 5. POP-UP MODAL: PETA KONSEP (LUAS & JELAS)
        // ========================================================
        function openConceptMapModal() {
            if (!currentConceptMap || !currentConceptMap.cabang || currentConceptMap.cabang.length === 0) {
                alert('Belum ada diagram peta konsep. Silakan tambahkan dokumen sumber terlebih dahulu.');
                openSourceModal();
                return;
            }
            const m = document.getElementById('conceptMapModal');
            const c = document.getElementById('conceptMapModalCard');
            m.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                c.classList.remove('scale-95');
                c.classList.add('scale-100');
            }, 50);

            conceptZoomLevel = 1.0;
            renderConceptMapModal();
        }

        function closeConceptMapModal() {
            const m = document.getElementById('conceptMapModal');
            const c = document.getElementById('conceptMapModalCard');
            c.classList.remove('scale-100');
            c.classList.add('scale-95');
            setTimeout(() => {
                m.classList.add('opacity-0', 'pointer-events-none');
            }, 200);
        }

        function zoomConceptMap(delta) {
            conceptZoomLevel = Math.max(0.7, Math.min(1.4, conceptZoomLevel + delta));
            const content = document.getElementById('conceptMapContent');
            if (content) content.style.transform = `scale(${conceptZoomLevel})`;
        }

        function renderConceptMapModal() {
            const peta = currentConceptMap;
            if (!peta) return;

            document.getElementById('modalRootConceptTitle').innerText = peta.topik_utama || 'Materi Utama';
            document.getElementById('modalConclusionText').innerText = peta.kesimpulan || 'Intisari Konseptual Menyeluruh';

            const container = document.getElementById('modalBranchesContainer');
            container.innerHTML = '';

            const branchColors = [
                { bg: 'bg-indigo-50/70', border: 'border-indigo-200', text: 'text-indigo-900', badge: 'bg-indigo-100 text-indigo-700' },
                { bg: 'bg-emerald-50/70', border: 'border-emerald-200', text: 'text-emerald-900', badge: 'bg-emerald-100 text-emerald-700' },
                { bg: 'bg-amber-50/70', border: 'border-amber-200', text: 'text-amber-900', badge: 'bg-amber-100 text-amber-700' },
                { bg: 'bg-violet-50/70', border: 'border-violet-200', text: 'text-violet-900', badge: 'bg-violet-100 text-violet-700' }
            ];

            (peta.cabang || []).forEach((c, idx) => {
                const color = branchColors[idx % branchColors.length];
                container.innerHTML += `
                    <div class="p-5 ${color.bg} border ${color.border} rounded-2xl shadow-xs space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="${color.badge} text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                Cabang ${idx + 1}
                            </span>
                            <i class="ph-bold ph-git-branch text-base ${color.text}"></i>
                        </div>
                        <h4 class="font-extrabold text-sm sm:text-base ${color.text}">
                            ${escapeHtml(c.nama)}
                        </h4>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">
                            ${escapeHtml(c.detail)}
                        </p>
                    </div>
                `;
            });
        }

        function claimConceptExp() {
            if (conceptExplored) {
                alert('Anda telah mengeksplorasi peta konsep ini!');
                return;
            }
            conceptExplored = true;
            localStorage.setItem('loma_concept_explored', 'true');
            addExp(30, 'Eksplorasi Peta Konsep');

            const questMap = document.getElementById('questCheckMap');
            if (questMap) questMap.className = "ph-fill ph-check-circle text-emerald-400";

            const btn = document.getElementById('btnClaimConceptExp');
            if (btn) {
                btn.className = "px-4 py-2 bg-slate-100 text-slate-500 rounded-xl text-xs font-bold cursor-not-allowed";
                btn.innerHTML = `<i class="ph-fill ph-check text-emerald-500"></i> Sudah Dipahami`;
            }
        }

        // --- Keyboard Controls for Modals ---
        document.addEventListener('keydown', (e) => {
            const fcModal = document.getElementById('flashcardModal');
            if (fcModal && !fcModal.classList.contains('pointer-events-none')) {
                if (e.code === 'Space') {
                    e.preventDefault();
                    flipFlashcard();
                } else if (e.code === 'ArrowRight') {
                    nextFlashcard();
                } else if (e.code === 'ArrowLeft') {
                    prevFlashcard();
                } else if (e.code === 'Escape') {
                    closeFlashcardModal();
                }
            }
            const qModal = document.getElementById('quizModal');
            if (qModal && !qModal.classList.contains('pointer-events-none')) {
                if (e.code === 'ArrowRight') nextQuizQuestion();
                if (e.code === 'ArrowLeft') prevQuizQuestion();
                if (e.code === 'Escape') closeQuizModal();
            }
            const cmModal = document.getElementById('conceptMapModal');
            if (cmModal && !cmModal.classList.contains('pointer-events-none')) {
                if (e.code === 'Escape') closeConceptMapModal();
            }
            const lvlModal = document.getElementById('levelUpModal');
            if (lvlModal && !lvlModal.classList.contains('pointer-events-none')) {
                if (e.code === 'Escape') closeLevelUpModal();
            }
        });

        document.getElementById('levelUpModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeLevelUpModal();
        });

        // --- Level & Tiers Modal Logic ---
        function renderLevelModal(isLevelUp = false) {
            const info = getLevelInfo(userExp);
            const currentLvlIdx = LEVEL_THRESHOLDS.findIndex(t => t.level === info.level);
            const currentTier = LEVEL_THRESHOLDS[currentLvlIdx] || LEVEL_THRESHOLDS[0];
            const nextTier = LEVEL_THRESHOLDS[currentLvlIdx + 1] || null;

            // Celebration banner (only on actual level up)
            const celeb = document.getElementById('modalLevelUpCelebration');
            if (celeb) {
                if (isLevelUp) {
                    celeb.classList.remove('hidden');
                    const celebTitle = document.getElementById('modalLevelUpCelebrationTitle');
                    const celebDesc = document.getElementById('modalLevelUpCelebrationDesc');
                    if (celebTitle) celebTitle.innerText = `Level ${info.level}: ${info.title} Berhasil Diraih!`;
                    if (celebDesc) celebDesc.innerText = `Luar biasa! Total perolehan Anda kini ${userExp} XP. Terus tingkatkan capaian belajar Anda!`;
                } else {
                    celeb.classList.add('hidden');
                }
            }

            // Current Hero info
            const iconEl = document.getElementById('modalCurrentLevelIcon');
            if (iconEl) iconEl.className = `ph-fill ${info.icon}`;

            const badgeEl = document.getElementById('modalCurrentLevelBadge');
            if (badgeEl) badgeEl.innerText = `LEVEL ${info.level}`;

            const rankEl = document.getElementById('modalCurrentRankTitle');
            if (rankEl) rankEl.innerText = info.title;

            const streakEl = document.getElementById('modalCurrentStreakText');
            if (streakEl) streakEl.innerText = `🔥 ${userStreak} Hari Streak`;

            const expEl = document.getElementById('modalCurrentTotalExp');
            if (expEl) expEl.innerText = `${userExp} XP`;

            const barEl = document.getElementById('modalCurrentProgressBar');
            if (barEl) barEl.style.width = `${info.progress}%`;

            const percentEl = document.getElementById('modalCurrentProgressPercent');
            if (percentEl) percentEl.innerText = `${info.progress}%`;

            const ratioEl = document.getElementById('modalCurrentExpRatio');
            const remainingEl = document.getElementById('modalCurrentRemainingText');

            if (nextTier) {
                const remainingExp = Math.max(0, nextTier.min - userExp);
                if (ratioEl) ratioEl.innerText = `${userExp} / ${nextTier.min} XP`;
                if (remainingEl) remainingEl.innerText = `${remainingExp} XP lagi menuju Level ${nextTier.level} (${nextTier.title})`;
            } else {
                if (ratioEl) ratioEl.innerText = `${userExp} XP (Level Maksimal)`;
                if (remainingEl) remainingEl.innerText = `Selamat! Anda telah mencapai level tertinggi!`;
            }

            // Render all 6 tiers
            const tiersList = document.getElementById('modalLevelTiersList');
            if (tiersList) {
                let html = '';
                LEVEL_THRESHOLDS.forEach((tier) => {
                    const isCurrent = (tier.level === info.level);
                    const isCompleted = (tier.level < info.level);
                    const isLocked = (tier.level > info.level);

                    if (isCurrent) {
                        html += `
                            <div class="p-3 sm:p-3.5 rounded-2xl border-2 border-indigo-600 bg-indigo-50/90 shadow-sm flex items-center justify-between gap-3 relative overflow-hidden ring-2 ring-indigo-200/70 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-lg font-black shrink-0 shadow-xs">
                                        <i class="ph-fill ${tier.icon}"></i>
                                    </div>
                                    <div>
                                        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                                            <h5 class="font-extrabold text-xs sm:text-sm text-indigo-950">Level ${tier.level}: ${tier.title}</h5>
                                            <span class="bg-indigo-600 text-white text-[9px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider flex items-center gap-1 shadow-2xs">
                                                <i class="ph-bold ph-check"></i> Level Saat Ini
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-indigo-700 font-semibold mt-0.5">${tier.min} - ${tier.max ? tier.max + ' XP' : '+ EXP'} • ${info.progress}% tercapai</p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="text-xs font-black text-indigo-700 bg-white border border-indigo-200 px-2.5 py-1 rounded-lg shadow-2xs">${userExp} XP</span>
                                </div>
                            </div>
                        `;
                    } else if (isCompleted) {
                        html += `
                            <div class="p-2.5 sm:p-3 rounded-2xl border border-emerald-200 bg-emerald-50/50 flex items-center justify-between gap-3 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 border border-emerald-200 flex items-center justify-center text-base font-bold shrink-0">
                                        <i class="ph-fill ${tier.icon}"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <h5 class="font-bold text-xs text-slate-800">Level ${tier.level}: ${tier.title}</h5>
                                            <span class="text-emerald-700 text-[10px] font-bold flex items-center gap-0.5">
                                                <i class="ph-bold ph-check-circle text-emerald-600"></i> Selesai
                                            </span>
                                        </div>
                                        <p class="text-[10px] text-slate-500 font-medium">${tier.min} - ${tier.max ? tier.max + ' XP' : '+ EXP'}</p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100/70 border border-emerald-200 px-2 py-0.5 rounded-md">Tercapai</span>
                                </div>
                            </div>
                        `;
                    } else {
                        const needExp = Math.max(0, tier.min - userExp);
                        html += `
                            <div class="p-2.5 sm:p-3 rounded-2xl border border-slate-200 bg-slate-50/70 flex items-center justify-between gap-3 opacity-75 hover:opacity-100 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-200 text-slate-500 flex items-center justify-center text-base font-bold shrink-0">
                                        <i class="ph-fill ${tier.icon}"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <h5 class="font-bold text-xs text-slate-700">Level ${tier.level}: ${tier.title}</h5>
                                            <span class="text-slate-400 text-[10px] font-medium flex items-center gap-0.5">
                                                <i class="ph-bold ph-lock"></i> Terkunci
                                            </span>
                                        </div>
                                        <p class="text-[10px] text-slate-500 font-medium">${tier.min} - ${tier.max ? tier.max + ' XP' : '+ EXP'}</p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="text-[10px] font-semibold text-slate-500 bg-white border border-slate-200 px-2 py-0.5 rounded-md">Butuh ${needExp} XP</span>
                                </div>
                            </div>
                        `;
                    }
                });
                tiersList.innerHTML = html;
            }
        }

        function openLevelUpModal(isLevelUp = false) {
            renderLevelModal(isLevelUp);
            const m = document.getElementById('levelUpModal');
            const card = document.getElementById('levelUpModalCard');
            if (m && card) {
                m.classList.remove('opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    card.classList.remove('scale-95');
                    card.classList.add('scale-100');
                }, 50);
            }
        }

        function closeLevelUpModal() {
            const m = document.getElementById('levelUpModal');
            const card = document.getElementById('levelUpModalCard');
            if (m && card) {
                card.classList.remove('scale-100');
                card.classList.add('scale-95');
                setTimeout(() => {
                    m.classList.add('opacity-0', 'pointer-events-none');
                }, 200);
            }
        }

        // --- Source Modal Logic ---
        function openSourceModal() {
            const m = document.getElementById('sourceModal');
            const c = document.getElementById('sourceModalCard');
            m.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                c.classList.remove('scale-95');
                c.classList.add('scale-100');
            }, 50);
        }

        function closeSourceModal() {
            const m = document.getElementById('sourceModal');
            const c = document.getElementById('sourceModalCard');
            c.classList.remove('scale-100');
            c.classList.add('scale-95');
            setTimeout(() => {
                m.classList.add('opacity-0', 'pointer-events-none');
            }, 200);
        }

        function switchModalTab(tab) {
            activeModalTab = tab;
            document.querySelectorAll('.modal-content').forEach(c => {
                c.classList.remove('block');
                c.classList.add('hidden');
            });
            document.querySelectorAll('.modal-tab-btn').forEach(b => {
                b.className = "modal-tab-btn flex-1 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center justify-center gap-1.5 transition-colors";
            });

            document.getElementById(`modalContent-${tab}`).classList.remove('hidden');
            document.getElementById(`modalContent-${tab}`).classList.add('block');
            document.getElementById(`mTabModal-${tab}`).className = "modal-tab-btn flex-1 py-1.5 rounded-lg text-xs font-bold bg-white text-indigo-700 shadow-sm flex items-center justify-center gap-1.5";
        }

        function handleModalFileChange(input) {
            if (input.files && input.files[0]) {
                document.getElementById('dropzoneTitle').innerText = input.files[0].name;
            }
        }

        async function processAddSource() {
            const btnText = document.getElementById('btnProcessText');
            const btnIcon = document.getElementById('btnProcessIcon');
            const btnSpinner = document.getElementById('btnProcessSpinner');
            const btn = document.getElementById('btnProcessSource');

            let formData = new FormData();
            formData.append('input_type', activeModalTab);

            let newSourceItem = null;

            if (activeModalTab === 'file') {
                const fileInput = document.getElementById('modalFileInput');
                if (!fileInput.files || fileInput.files.length === 0) {
                    alert('Pilih file dokumen terlebih dahulu!');
                    return;
                }
                const file = fileInput.files[0];
                formData.append('file', file);
                const ext = file.name.split('.').pop().toUpperCase();
                newSourceItem = { type: ext, title: file.name, desc: 'Dokumen diunggah pengguna', checked: true };
            } else if (activeModalTab === 'url') {
                const urlInput = document.getElementById('modalUrlInput');
                const url = urlInput.value.trim();
                if (!url) {
                    alert('Masukkan URL artikel yang valid!');
                    return;
                }
                formData.append('url', url);
                newSourceItem = { type: 'URL', title: url.replace(/^https?:\/\//, ''), desc: 'Sumber artikel website', checked: true };
            } else {
                const textInput = document.getElementById('modalTextInput');
                const text = textInput.value.trim();
                if (!text) {
                    alert('Ketik atau tempel materi teks!');
                    return;
                }
                formData.append('materi', text);
                newSourceItem = { type: 'TXT', title: 'Catatan Manual', desc: text.substring(0, 50) + '...', checked: true };
            }

            btn.disabled = true;
            btnText.innerText = "Memproses dengan AI...";
            btnIcon.classList.add('hidden');
            btnSpinner.classList.remove('hidden');

            try {
                const response = await fetch('{{ url("/api/process-ai") }}', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: formData
                });
                const result = await response.json();

                if (result.status === 'success') {
                    if (newSourceItem) {
                        newSourceItem.fullText = result.data.extracted_text || '';
                        newSourceItem.desc = (result.data.rangkuman || '').substring(0, 75) + '...';
                        currentSources.unshift(newSourceItem);
                        renderSourcesList();
                    }

                    if (result.data && result.data.title) {
                        const heroTitle = document.getElementById('summaryHeroTitle');
                        if (heroTitle) heroTitle.innerText = result.data.title;
                    }

                    if (result.data && result.data.rangkuman) {
                        let summaryHtml = `
                            <div class="bg-indigo-50/40 border border-indigo-100/80 rounded-xl p-4">
                                <h3 class="text-xs font-bold text-indigo-900 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                    <i class="ph-bold ph-bookmarks text-indigo-600"></i> Ringkasan Eksekutif
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">${result.data.rangkuman.replace(/\n/g, '<br>')}</p>
                            </div>
                        `;

                        if (result.data.poin_kunci && result.data.poin_kunci.length > 0) {
                            summaryHtml += `
                                <div>
                                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                                        <i class="ph-bold ph-list-checks text-emerald-600"></i> Poin Kunci yang Diekstrak
                                    </h3>
                                    <div class="grid grid-cols-1 gap-2.5">
                            `;
                            result.data.poin_kunci.forEach((point, idx) => {
                                const badgeColor = idx === 0 ? 'bg-indigo-50 border-indigo-100 text-indigo-700' : (idx === 1 ? 'bg-emerald-50 border-emerald-100 text-emerald-700' : 'bg-amber-50 border-amber-100 text-amber-700');
                                summaryHtml += `
                                    <div class="p-3.5 bg-white border border-slate-200/90 rounded-xl flex items-start gap-3 shadow-xs">
                                        <span class="w-6 h-6 rounded-lg ${badgeColor} border text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">${idx + 1}</span>
                                        <div class="text-xs sm:text-sm text-slate-700 font-medium">${escapeHtml(point)}</div>
                                    </div>
                                `;
                            });
                            summaryHtml += `
                                    </div>
                                </div>
                            `;
                        }

                        document.getElementById('summaryContainer').innerHTML = summaryHtml;
                        const sumEmpty = document.getElementById('summaryEmptyState');
                        const sumCard = document.getElementById('summaryHeroCard');
                        if (sumEmpty) sumEmpty.classList.add('hidden');
                        if (sumCard) sumCard.classList.remove('hidden');
                        switchCenterTab('summary');
                    }

                    if (result.data && result.data.flashcards && result.data.flashcards.length > 0) {
                        flashcardsData = result.data.flashcards.map(f => ({ front: f.depan, back: f.belakang }));
                        currentFlashcardIdx = 0;
                        const fcCountEl = document.getElementById('studioCardCount');
                        if (fcCountEl) fcCountEl.innerText = `${flashcardsData.length} Kartu Aktif`;
                    }

                    if (result.data && result.data.kuis && result.data.kuis.length > 0) {
                        currentQuizData = result.data.kuis;
                        answeredQuestions = {};
                        isQuizSubmitted = false;
                        currentQuizIndex = 0;
                        const resultBanner = document.getElementById('quizResultBanner');
                        if (resultBanner) resultBanner.innerHTML = '';
                        updateQuizSubmitButton();
                        const quizCountEl = document.getElementById('studioQuizCount');
                        if (quizCountEl) quizCountEl.innerText = `${currentQuizData.length} Soal Tersedia`;
                    }

                    if (result.data && result.data.peta_konsep) {
                        currentConceptMap = result.data.peta_konsep;
                        conceptExplored = false;
                        const branchesCountEl = document.getElementById('studioBranchesCount');
                        if (branchesCountEl && currentConceptMap.cabang) {
                            branchesCountEl.innerText = `${currentConceptMap.cabang.length} Cabang Konsep`;
                        }
                    }

                    // Award EXP for adding a new document
                    addExp(50, 'Tambah Sumber Belajar Baru');

                    closeSourceModal();
                    alert('Sumber materi baru berhasil dianalisis oleh AI dan ditambahkan!');
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (err) {
                if (newSourceItem) {
                    currentSources.unshift(newSourceItem);
                    renderSourcesList();
                    const sumEmpty = document.getElementById('summaryEmptyState');
                    const sumCard = document.getElementById('summaryHeroCard');
                    if (sumEmpty) sumEmpty.classList.add('hidden');
                    if (sumCard) sumCard.classList.remove('hidden');
                    const heroTitle = document.getElementById('summaryHeroTitle');
                    if (heroTitle) heroTitle.innerText = newSourceItem.title;
                    document.getElementById('summaryContainer').innerHTML = `
                        <div class="bg-indigo-50/40 border border-indigo-100/80 rounded-xl p-4">
                            <h3 class="text-xs font-bold text-indigo-900 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                <i class="ph-bold ph-bookmarks text-indigo-600"></i> Dokumen Sumber Terunggah
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">${escapeHtml(newSourceItem.title)} berhasil ditambahkan ke daftar sumber aktif Anda.</p>
                        </div>
                    `;
                }
                closeSourceModal();
                alert('Sumber berhasil ditambahkan!');
            } finally {
                btn.disabled = false;
                btnText.innerText = "Tambahkan Sumber";
                btnIcon.classList.remove('hidden');
                btnSpinner.classList.add('hidden');
            }
        }

        function escapeHtml(string) {
            return String(string).replace(/[&<>"'`=\/]/g, function (s) {
                return ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;',
                    '/': '&#x2F;',
                    '`': '&#x60;',
                    '=': '&#x3D;'
                })[s];
            });
        }

        // Initialize UI State
        updateGamificationUI();
        renderSourcesList();

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
