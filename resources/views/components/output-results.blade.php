<!-- RESULTS SECTION (COMPONENT) -->
<section id="resultSection" class="hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-[fadeIn_0.5s_ease-out]">
        
        <!-- Header Rangkuman & Audio -->
        <div class="retro-card rounded-2xl p-8 col-span-1 md:col-span-2 relative overflow-hidden">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 border-b-3 border-dark pb-6 relative z-10">
                <h3 class="text-3xl font-black flex items-center gap-3 text-dark">
                    <div class="p-2 bg-accent text-dark border-2 border-dark shadow-[2px_2px_0_0_#3e2723] rounded-xl"><i class="ph ph-list-dashes"></i></div>
                    Rangkuman Materi
                </h3>
                
                <!-- Audio Player (Gamified AI Voice) -->
                <div class="flex items-center gap-4 bg-light border-3 border-dark p-2 pr-5 rounded-full shadow-[4px_4px_0_0_#3e2723]">
                    <button id="playAudioBtn" class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white border-2 border-dark retro-btn">
                        <i class="ph ph-play-fill text-xl" id="playIcon"></i>
                    </button>
                    <div class="flex flex-col">
                        <span class="text-xs text-dark/70 font-bold uppercase tracking-wider">AI Podcast</span>
                        <div class="flex items-center gap-1 mt-1" id="audioBars">
                            <!-- Visualizer bars (static initially) -->
                            <div class="w-1.5 h-3 bg-dark rounded-full"></div>
                            <div class="w-1.5 h-5 bg-dark rounded-full"></div>
                            <div class="w-1.5 h-2 bg-dark rounded-full"></div>
                            <div class="w-1.5 h-6 bg-dark rounded-full"></div>
                            <div class="w-1.5 h-4 bg-dark rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="summaryOutput" class="text-dark leading-relaxed text-xl font-medium relative z-10"></div>
        </div>

        <!-- Mindmap Placeholder & Visualisasi -->
        <div class="retro-card rounded-2xl p-8 flex flex-col">
            <h3 class="text-2xl font-black mb-6 pb-4 border-b-3 border-dark flex items-center gap-3 text-dark">
                <i class="ph ph-git-branch text-primary"></i> Peta Konsep
            </h3>
            
            <div class="w-full flex-grow bg-light border-3 border-dark rounded-xl overflow-hidden relative flex items-center justify-center min-h-[250px] shadow-inner">
                <div id="visualPlaceholder" class="text-center p-6 absolute">
                    <i class="ph ph-tree-structure text-6xl text-dark/20 mb-3 block"></i>
                    <p class="text-dark/50 font-bold">Mind Map AI Area</p>
                </div>
                <!-- Image Overlay -->
                <img id="visualImage" src="" alt="Visualisasi" class="w-full h-full object-cover hidden relative z-10">
            </div>
        </div>

        <!-- Flashcards Section -->
        <div class="retro-card rounded-2xl p-8 flex flex-col">
            <h3 class="text-2xl font-black mb-6 pb-4 border-b-3 border-dark flex items-center justify-between text-dark">
                <span class="flex items-center gap-3"><i class="ph ph-cards text-secondary"></i> Kartu Pintar</span>
                <span class="text-sm bg-accent border-2 border-dark text-dark px-3 py-1 rounded-full font-bold shadow-[2px_2px_0_0_#3e2723]" id="flashcardCounter">1/3</span>
            </h3>
            
            <div class="relative w-full flex-grow min-h-[250px] perspective-1000" id="flashcardContainer">
                <!-- Cards will be injected here via JS -->
            </div>
            
            <div class="flex justify-between items-center mt-6">
                <button id="prevCard" class="p-3 bg-white border-2 border-dark rounded-xl text-dark retro-btn"><i class="ph ph-caret-left text-xl"></i></button>
                <span class="text-sm text-dark/60 font-bold">Klik kartu untuk membalik</span>
                <button id="nextCard" class="p-3 bg-white border-2 border-dark rounded-xl text-dark retro-btn"><i class="ph ph-caret-right text-xl"></i></button>
            </div>
        </div>

        <!-- Kuis Interaktif -->
        <div class="retro-card rounded-2xl p-8 col-span-1 md:col-span-2 relative overflow-hidden">
            
            <div class="flex justify-between items-end mb-8 border-b-3 border-dark pb-6 relative z-10">
                <div>
                    <h3 class="text-3xl font-black flex items-center gap-3 mb-2 text-dark">
                        <div class="p-2 bg-secondary text-white border-2 border-dark shadow-[2px_2px_0_0_#3e2723] rounded-xl"><i class="ph ph-game-controller"></i></div>
                        Kuis Tantangan
                    </h3>
                    <p class="text-dark/70 font-medium">Uji pemahaman Anda dan dapatkan EXP!</p>
                </div>
                <div class="text-right hidden" id="expRewardBadge">
                    <span class="inline-flex items-center gap-2 bg-accent text-dark px-4 py-2 rounded-full text-lg font-black border-2 border-dark shadow-[4px_4px_0_0_#3e2723] animate-bounce">
                        <i class="ph ph-star-fill text-primary"></i> +150 EXP
                    </span>
                </div>
            </div>

            <div id="quizContainer" class="flex flex-col gap-6 relative z-10"></div>
            
            <div id="quizActions" class="mt-8 flex flex-col md:flex-row items-center justify-between hidden relative z-10 gap-4">
                <div id="quizFeedback" class="font-black text-xl flex items-center gap-2"></div>
                <button id="checkAnswerBtn" class="w-full md:w-auto bg-secondary text-white border-2 border-dark px-8 py-4 rounded-xl font-black text-lg retro-btn flex items-center justify-center gap-2">
                    <i class="ph ph-check-circle text-2xl"></i> Cek Jawaban
                </button>
            </div>
            
            <!-- Gamification Level Up Overlay -->
            <div id="levelUpOverlay" class="absolute inset-0 bg-light/90 backdrop-blur-sm z-50 flex flex-col items-center justify-center opacity-0 pointer-events-none transition-opacity duration-500 rounded-xl border-3 border-dark">
                <div class="transform scale-50 opacity-0 transition-all duration-700 delay-100 flex flex-col items-center text-center p-8 bg-white border-4 border-dark rounded-3xl shadow-[8px_8px_0_0_#3e2723]" id="levelUpContent">
                    <div class="w-24 h-24 bg-accent border-4 border-dark rounded-full flex items-center justify-center mb-6 shadow-[4px_4px_0_0_#3e2723]">
                        <i class="ph ph-crown text-6xl text-dark"></i>
                    </div>
                    <h2 class="text-5xl font-black text-dark mb-4 uppercase">Sempurna!</h2>
                    <p class="text-2xl text-dark/80 font-bold mb-8">Anda mendapatkan <span class="text-primary font-black">+150 EXP</span></p>
                    <button onclick="document.getElementById('levelUpOverlay').classList.remove('opacity-100', 'pointer-events-auto')" class="bg-primary text-white border-2 border-dark px-8 py-3 rounded-xl font-black text-xl retro-btn">Tutup Layar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center mt-12 mb-12">
        <button id="resetBtn" class="bg-white text-dark border-3 border-dark px-8 py-4 rounded-xl font-black text-lg flex items-center gap-3 retro-btn">
            <i class="ph ph-arrow-counter-clockwise text-2xl"></i> Mulai Materi Baru
        </button>
    </div>
</section>
