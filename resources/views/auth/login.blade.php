<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk & Daftar | Loma.AI Gamifikasi</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
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
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
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

        .glass-card {
            background: #ffffff;
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-slate-50 flex flex-col justify-between selection:bg-indigo-500 selection:text-white relative overflow-x-hidden">

    <!-- Top Loading / Transition Bar -->
    <div id="pageTransitionBar" class="fixed top-0 left-0 w-0 h-1 bg-indigo-600 z-[99999] transition-all duration-300 pointer-events-none"></div>

    <!-- Navigation Header -->
    <header class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex items-center justify-between">
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

        <a href="{{ route('landing') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-indigo-600 bg-white border border-slate-200 px-3.5 py-2 rounded-xl shadow-xs transition-all">
            <i class="ph-bold ph-arrow-left"></i>
            <span>Kembali ke Beranda</span>
        </a>
    </header>

    <!-- Main Auth Section -->
    <main class="relative z-10 flex-grow flex items-center justify-center px-4 py-8 sm:px-6">
        <div class="w-full max-w-md">
            
            <!-- Card Container -->
            <div class="glass-card border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50">
                
                <!-- Tab Switcher (Masuk vs Daftar) -->
                <div class="flex bg-slate-100 p-1 rounded-xl mb-6 border border-slate-200/80">
                    <button type="button" id="tabBtnLogin" onclick="switchAuthMode('login')" class="flex-1 py-2 text-xs font-extrabold rounded-lg transition-all flex items-center justify-center gap-1.5 {{ ($mode ?? 'login') === 'login' ? 'bg-white text-indigo-700 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                        <i class="ph-bold ph-sign-in"></i>
                        <span>Masuk Akun</span>
                    </button>
                    <button type="button" id="tabBtnRegister" onclick="switchAuthMode('register')" class="flex-1 py-2 text-xs font-extrabold rounded-lg transition-all flex items-center justify-center gap-1.5 {{ ($mode ?? 'login') === 'register' ? 'bg-white text-indigo-700 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                        <i class="ph-bold ph-user-plus"></i>
                        <span>Daftar Baru</span>
                    </button>
                </div>

                <!-- Header Title -->
                <div class="text-center mb-6">
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight" id="authTitle">
                        {{ ($mode ?? 'login') === 'login' ? 'Selamat Datang Kembali!' : 'Mulai Petualangan Belajar' }}
                    </h1>
                    <p class="text-xs text-slate-500 mt-1 font-medium" id="authSubtitle">
                        {{ ($mode ?? 'login') === 'login' ? 'Masuk untuk melanjutkan progress EXP dan modul Anda' : 'Buat akun gratis dan dapatkan 100 EXP Starter Pack' }}
                    </p>
                </div>

                <!-- Notification Alerts -->
                @if($errors->any())
                    <div class="mb-4 p-3.5 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-xs font-medium space-y-1.5">
                        <div class="flex items-center gap-2 font-bold text-rose-900">
                            <i class="ph-bold ph-warning-circle text-rose-600 text-base shrink-0"></i>
                            <span>Pemberitahuan:</span>
                        </div>
                        <ul class="list-disc list-inside pl-1 text-[11px] text-rose-700 space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-3 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs font-medium flex items-center gap-2">
                        <i class="ph-bold ph-warning-circle text-rose-600 text-base shrink-0"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if(session('success'))
                    <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs font-medium flex items-center gap-2">
                        <i class="ph-bold ph-check-circle text-emerald-600 text-base shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('info'))
                    <div class="mb-4 p-3 bg-indigo-50 border border-indigo-200 rounded-xl text-indigo-800 text-xs font-medium flex items-center gap-2">
                        <i class="ph-bold ph-info text-indigo-600 text-base shrink-0"></i>
                        <span>{{ session('info') }}</span>
                    </div>
                @endif

                <!-- Auth Form -->
                <form id="authForm" method="POST" action="{{ ($mode ?? 'login') === 'login' ? route('login.post') : route('register.post') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="auth_mode" id="authModeInput" value="{{ ($mode ?? 'login') === 'register' ? 'register' : 'login' }}">
                    
                    <!-- Name Input (Register Only) -->
                    <div id="fieldContainerName" class="{{ ($mode ?? 'login') === 'login' ? 'hidden' : 'block' }}">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <i class="ph-bold ph-user absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                            <input type="text" name="name" id="inputName" value="{{ old('name') }}" placeholder="Contoh: Ahmad Fadilah" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all font-medium">
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <i class="ph-bold ph-envelope-simple absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                            <input type="email" name="email" id="inputEmail" value="{{ old('email') }}" required placeholder="nama@email.com" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all font-medium">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700">Kata Sandi</label>
                            <a href="#" id="forgotPasswordLink" class="text-[11px] font-semibold text-indigo-600 hover:text-indigo-800 {{ ($mode ?? 'login') === 'login' ? 'inline' : 'hidden' }}">Lupa kata sandi?</a>
                        </div>
                        <div class="relative">
                            <i class="ph-bold ph-lock-key absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                            <input type="password" name="password" id="inputPassword" required placeholder="••••••••" class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all font-medium">
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                                <i class="ph-bold ph-eye" id="passwordEyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me (Login Only) -->
                    <div id="rememberMeContainer" class="flex items-center justify-between pt-1 {{ ($mode ?? 'login') === 'login' ? 'flex' : 'hidden' }}">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-indigo-600 accent-indigo-600 focus:ring-indigo-500">
                            <span class="text-xs text-slate-600 font-medium">Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="btnSubmit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs sm:text-sm font-bold shadow-md shadow-indigo-200 hover:shadow-indigo-300 transition-all hover:scale-[1.01] flex items-center justify-center gap-2">
                        <i class="ph-bold ph-sign-in" id="btnSubmitIcon"></i>
                        <span id="btnSubmitText">{{ ($mode ?? 'login') === 'login' ? 'Masuk Sekarang' : 'Daftar Akun Gratis' }}</span>
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                    <div class="relative flex justify-center text-[10px] uppercase font-bold tracking-wider text-slate-400">
                        <span class="bg-white px-3">Atau masuk dengan</span>
                    </div>
                </div>

                <!-- Social Login: Google Button (Full width, Belajar.id removed) -->
                <div>
                    <a href="{{ route('google.login') }}" id="btnGoogleAuth" class="w-full flex items-center justify-center gap-2.5 py-2.5 px-4 border border-slate-200 hover:border-slate-300 rounded-xl bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 transition-all shadow-xs hover:shadow-sm">
                        <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                        <span>Lanjutkan dengan Akun Google</span>
                    </a>
                </div>

                <!-- Footer Toggle Note -->
                <div class="mt-6 text-center text-xs text-slate-500 font-medium">
                    <span id="footerTogglePrompt">{{ ($mode ?? 'login') === 'login' ? 'Belum memiliki akun?' : 'Sudah punya akun?' }}</span>
                    <button type="button" onclick="toggleAuthMode()" class="font-bold text-indigo-600 hover:text-indigo-800 ml-1 underline decoration-indigo-200 hover:decoration-indigo-600">
                        <span id="footerToggleAction">{{ ($mode ?? 'login') === 'login' ? 'Daftar sekarang gratis' : 'Masuk ke akun' }}</span>
                    </button>
                </div>

            </div>

            <!-- Gamification Trust Footer Banner -->
            <div class="mt-6 p-4 rounded-2xl bg-indigo-50/70 border border-indigo-100 flex items-center gap-3 shadow-xs">
                <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-lg font-bold shrink-0 shadow-sm">
                    <i class="ph-fill ph-trophy"></i>
                </div>
                <div>
                    <h4 class="text-xs font-extrabold text-indigo-950">Belajar Berbasis Gamifikasi</h4>
                    <p class="text-[11px] text-slate-600 leading-snug">Dapatkan poin EXP, taklukkan kuis 15 soal, dan latih memori dengan kartu flashcard 3D.</p>
                </div>
            </div>

        </div>
    </main>

    <!-- Simple Footer -->
    <footer class="relative z-10 w-full py-4 text-center text-[11px] text-slate-400">
        &copy; {{ date('Y') }} Loma.AI Gamifikasi. Hak cipta dilindungi undang-undang.
    </footer>

    <script>
        let currentMode = "{{ $mode ?? 'login' }}";

        function switchAuthMode(mode) {
            currentMode = mode;
            const tabLogin = document.getElementById('tabBtnLogin');
            const tabReg = document.getElementById('tabBtnRegister');
            const nameContainer = document.getElementById('fieldContainerName');
            const remContainer = document.getElementById('rememberMeContainer');
            const forgotLink = document.getElementById('forgotPasswordLink');
            const title = document.getElementById('authTitle');
            const subtitle = document.getElementById('authSubtitle');
            const form = document.getElementById('authForm');
            const btnText = document.getElementById('btnSubmitText');
            const btnIcon = document.getElementById('btnSubmitIcon');
            const footerPrompt = document.getElementById('footerTogglePrompt');
            const footerAction = document.getElementById('footerToggleAction');

            const authModeInput = document.getElementById('authModeInput');
            const inputName = document.getElementById('inputName');

            if (authModeInput) {
                authModeInput.value = mode;
            }

            if (mode === 'login') {
                tabLogin.className = "flex-1 py-2 text-xs font-extrabold rounded-lg transition-all flex items-center justify-center gap-1.5 bg-white text-indigo-700 shadow-sm";
                tabReg.className = "flex-1 py-2 text-xs font-extrabold rounded-lg transition-all flex items-center justify-center gap-1.5 text-slate-600 hover:text-slate-900";
                
                nameContainer.classList.add('hidden');
                if (inputName) inputName.removeAttribute('required');
                remContainer.classList.remove('hidden');
                remContainer.classList.add('flex');
                forgotLink.classList.remove('hidden');
                
                title.innerText = "Selamat Datang Kembali!";
                subtitle.innerText = "Masuk untuk melanjutkan progress EXP dan modul Anda";
                
                form.action = "{{ route('login.post') }}";
                btnText.innerText = "Masuk Sekarang";
                btnIcon.className = "ph-bold ph-sign-in";
                
                footerPrompt.innerText = "Belum memiliki akun?";
                footerAction.innerText = "Daftar sekarang gratis";
            } else {
                tabReg.className = "flex-1 py-2 text-xs font-extrabold rounded-lg transition-all flex items-center justify-center gap-1.5 bg-white text-indigo-700 shadow-sm";
                tabLogin.className = "flex-1 py-2 text-xs font-extrabold rounded-lg transition-all flex items-center justify-center gap-1.5 text-slate-600 hover:text-slate-900";
                
                nameContainer.classList.remove('hidden');
                if (inputName) inputName.setAttribute('required', 'required');
                remContainer.classList.add('hidden');
                remContainer.classList.remove('flex');
                forgotLink.classList.add('hidden');
                
                title.innerText = "Mulai Petualangan Belajar";
                subtitle.innerText = "Buat akun gratis dan dapatkan 100 EXP Starter Pack";
                
                form.action = "{{ route('register.post') }}";
                btnText.innerText = "Daftar Akun Gratis";
                btnIcon.className = "ph-bold ph-user-plus";
                
                footerPrompt.innerText = "Sudah punya akun?";
                footerAction.innerText = "Masuk ke akun";
            }
        }

        function toggleAuthMode() {
            switchAuthMode(currentMode === 'login' ? 'register' : 'login');
        }

        function togglePasswordVisibility() {
            const input = document.getElementById('inputPassword');
            const icon = document.getElementById('passwordEyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'ph-bold ph-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'ph-bold ph-eye';
            }
        }

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
