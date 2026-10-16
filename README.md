# Loma.AI - Ruang Belajar Cerdas & Gamifikasi Active Recall 🚀

Loma.AI adalah platform gamifikasi edukasi modern yang mengintegrasikan kecerdasan buatan (AI) dengan prinsip neurosains memori (**Active Recall** & **Spaced Repetition**). Platform ini membantu pelajar dan mahasiswa memahami materi bacaan, dokumen ilmiah, modul perkuliahan, dan referensi belajar secara mendalam, cepat, dan menyenangkan.

---

## 🌟 Fitur Utama

- 🧠 **AI Knowledge Extraction & Synthesis**: Meringkas dokumen teks, artikel, file PDF, dan referensi belajar menjadi ringkasan eksekutif dan poin kunci terstruktur.
- 🎮 **Ujian Tantangan Active Recall (Kuis Pilihan Ganda)**: Evaluasi pemahaman otomatis dengan umpan balik instan (*instant feedback*), visualisasi benar/salah, pembahasan mendalam, dan reward EXP.
- 📇 **3D Active Recall Flashcards**: Kartu memori interaktif dengan animasi 3D flip untuk melatih *retrieval practice*.
- 🗺️ **Peta Konsep Pop-Up Interaktif**: Visualisasi hierarki hubungan antar materi dan konsep secara logis dari umum ke spesifik.
- 🏆 **Gamifikasi Lengkap (EXP, Level, & Streak)**:
  - Pelajar Pemula (Lvl 1) hingga Grandmaster Belajar (Lvl 6)
  - Daily Streak & Quest Tracker
  - Progress bar level real-time
- 💬 **Tanya Dokumen (Chat RAG AI)**: Fitur asisten cerdas untuk menanyakan topik spesifik langsung dari dokumen yang diunggah.
- 🔐 **Autentikasi Aman**: Mendukung login mandiri dan integrasi Google OAuth (SSO).

---

## 🛠️ Tech Stack

- **Backend**: [Laravel](https://laravel.com/) (PHP)
- **Database**: MySQL / MariaDB
- **Frontend**: Blade Templating, [Tailwind CSS](https://tailwindcss.com/), [Phosphor Icons](https://phosphoricons.com/)
- **AI Models**: Google Gemini 3.8 / 2.5 Flash & Groq LLaMA

---

## 🚀 Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal:

### 1. Clone Repositori
```bash
git clone https://github.com/Perdi-Ardiansyah/Loma-AI.git
cd Loma-AI
```

### 2. Install Dependensi PHP & JS
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan konfigurasi database dan API Key:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gamifikasi_loma
DB_USERNAME=root
DB_PASSWORD=

# Konfigurasi AI API Key
GEMINI_API_KEY=your_gemini_api_key_here
GROQ_API_KEY=your_groq_api_key_here
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Jalankan Database Migration & Seeder
```bash
php artisan migrate --seed
```

### 6. Jalankan Server Lokal
```bash
php artisan serve
```
Akses aplikasi melalui browser di: `http://localhost:8000`

---

## 📁 Struktur Penting Proyek

- `app/Http/Controllers/AIController.php`: Logika integrasi AI (Gemini / Groq), ekstraksi materi, dan pembangkitan kuis/flashcard.
- `app/Http/Controllers/AuthController.php`: Logika otentikasi pengguna, EXP sync, dan Google OAuth.
- `resources/views/welcome.blade.php`: Halaman ruang belajar studio (dashboard, kuis modal, flashcard 3D, chat dokumen).
- `resources/views/landing.blade.php`: Landing page interaktif.

---

## 📄 Lisensi

Proyek ini dikembangkan untuk kebutuhan edukasi dan riset pembelajaran cerdas.
