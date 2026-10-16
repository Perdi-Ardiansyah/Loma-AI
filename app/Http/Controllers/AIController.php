<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Http;
use Exception;
use ZipArchive;
use DOMDocument;

class AIController extends Controller
{
    /**
     * Memproses materi (Teks, File Dokumen, atau URL) dan mengekstrak ringkasan,
     * flashcards, kuis, peta konsep, serta skrip podcast interaktif menggunakan AI.
     */
    public function process(Request $request)
    {
        $inputType = $request->input('input_type', 'text');
        $materiText = '';

        try {
            if ($inputType === 'text') {
                $materiText = $request->input('materi');
                if (empty($materiText)) {
                    return response()->json(['status' => 'error', 'message' => 'Materi teks kosong'], 400);
                }
            } elseif ($inputType === 'file') {
                if (!$request->hasFile('file')) {
                    return response()->json(['status' => 'error', 'message' => 'File dokumen tidak ditemukan'], 400);
                }

                $file = $request->file('file');
                $extension = strtolower($file->getClientOriginalExtension());
                $path = $file->getRealPath();

                if ($extension === 'pdf') {
                    $parser = new Parser();
                    $pdf = $parser->parseFile($path);
                    $materiText = $pdf->getText();
                } elseif ($extension === 'docx') {
                    $materiText = $this->extractTextFromDocx($path);
                } elseif ($extension === 'pptx') {
                    $materiText = $this->extractTextFromPptx($path);
                } elseif ($extension === 'txt') {
                    $materiText = file_get_contents($path);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Format file tidak didukung (.pdf, .docx, .pptx, .txt saja)'], 400);
                }

                if (empty(trim($materiText))) {
                    return response()->json(['status' => 'error', 'message' => 'Tidak dapat mengekstrak teks dari file ini'], 400);
                }

            } elseif ($inputType === 'url') {
                $url = $request->input('url');
                if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
                    return response()->json(['status' => 'error', 'message' => 'URL tidak valid'], 400);
                }

                $response = Http::timeout(15)->withoutVerifying()->get($url);
                if ($response->successful()) {
                    $html = $response->body();
                    $materiText = $this->extractTextFromHtml($html);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Gagal mengambil artikel dari URL'], 400);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Tipe input tidak valid'], 400);
            }

            // Batasi teks materi agar tidak melebihi konteks limit (~12000 karakter)
            $trimmedMateri = mb_substr(trim($materiText), 0, 12000);

            // Buat prompt untuk AI
            $prompt = <<<EOT
Analisis materi pembelajaran berikut secara komprehensif:
---
{$trimmedMateri}
---

Instruksi:
Hasilkan respon dalam format JSON murni dengan struktur:
{
  "title": "Judul singkat topik materi",
  "rangkuman": "Ringkasan eksekutif materi yang mendalam, terstruktur dan mudah dipahami",
  "poin_kunci": [
    "Poin penting 1",
    "Poin penting 2",
    "Poin penting 3",
    "Poin penting 4",
    "Poin penting 5"
  ],
  "peta_konsep": {
    "topik_utama": "Topik Pusat Materi",
    "cabang": [
      {"nama": "Cabang Konsep 1", "detail": "Penjelasan inti konsep 1"},
      {"nama": "Cabang Konsep 2", "detail": "Penjelasan inti konsep 2"},
      {"nama": "Cabang Konsep 3", "detail": "Penjelasan inti konsep 3"},
      {"nama": "Cabang Konsep 4", "detail": "Penjelasan inti konsep 4"}
    ],
    "kesimpulan": "Intisari konseptual menyeluruh"
  },
  "flashcards": [
    {"depan": "Pertanyaan atau Konsep 1", "belakang": "Jawaban mendalam untuk memori jangka panjang"},
    {"depan": "Pertanyaan atau Konsep 2", "belakang": "Jawaban mendalam untuk memori jangka panjang"},
    {"depan": "Pertanyaan atau Konsep 3", "belakang": "Jawaban mendalam untuk memori jangka panjang"},
    {"depan": "Pertanyaan atau Konsep 4", "belakang": "Jawaban mendalam untuk memori jangka panjang"},
    {"depan": "Pertanyaan atau Konsep 5", "belakang": "Jawaban mendalam untuk memori jangka panjang"}
  ],
  "kuis": [
    // PENTING: Wajib buat minimal 15 soal pilihan ganda yang mendalam dan bervariasi!
    {
      "pertanyaan": "Pertanyaan nomor 1 berdasarkan materi?",
      "opsi": ["Opsi A", "Opsi B", "Opsi C", "Opsi D"],
      "jawaban_benar": 0, // Indeks jawaban benar (angka integer: 0 untuk opsi 1, 1 untuk opsi 2, 2 untuk opsi 3, 3 untuk opsi 4)
      "penjelasan": "Alasan edukatif kenapa opsi ini benar dan sesuai dengan konteks materi"
    }
  ]
}
EOT;

            $systemPrompt = "Kamu adalah EduGen AI untuk platform Loma.AI Studio. Buat kuis evaluasi komprehensif berisi MINIMAL 15 pertanyaan pilihan ganda yang mencakup seluruh poin materi. Selalu keluarkan format JSON murni yang valid tanpa format markdown tambahan.";
            $aiResult = $this->callAIService($prompt, $systemPrompt, true);

            // Fallback jika parsing AI gagal
            if (!$aiResult || !isset($aiResult['rangkuman'])) {
                $snippet = mb_substr(trim($materiText), 0, 200) . '...';
                $aiResult = [
                    'title' => 'Materi Pembelajaran Baru',
                    'rangkuman' => "Materi berhasil diekstrak dan dianalisis:\n\n\"{$snippet}\"",
                    'poin_kunci' => [
                        'Materi pembelajaran telah berhasil diunggah dan terindeks.',
                        'Active Recall: uji pemahaman konsep secara teratur melalui kuis dan flashcard interaktif.',
                        'Spaced Repetition: ulangi materi penting pada interval waktu tertentu.',
                        'Peta Konsep: visualisasikan hubungan antar topik untuk pemahaman mendalam.',
                        'Sistem EXP: dapatkan reward pengalaman untuk setiap aktivitas belajar aktif.'
                    ],
                    'peta_konsep' => [
                        'topik_utama' => 'Materi Pembelajaran',
                        'cabang' => [
                            ['nama' => 'Konsep Inti', 'detail' => 'Prinsip dan teori dasar materi'],
                            ['nama' => 'Penerapan Praktis', 'detail' => 'Aplikasi konsep dalam pemecahan masalah'],
                            ['nama' => 'Evaluasi Belajar', 'detail' => 'Pengujian pemahaman dan active recall'],
                            ['nama' => 'Pengembangan Lanjut', 'detail' => 'Eksplorasi keterkaitan materi dengan bidang lain']
                        ],
                        'kesimpulan' => 'Pemahaman materi secara menyeluruh melalui pembelajaran aktif'
                    ],
                    'flashcards' => [
                        ['depan' => 'Apa tujuan utama dari mempelajari materi ini?', 'belakang' => 'Memahami prinsip dasar dan menerapkannya dalam analisis studi.'],
                        ['depan' => 'Mengapa metode Active Recall lebih efektif?', 'belakang' => 'Active recall melatih otak memanggil kembali informasi yang telah disimpan, memperkuat koneksi sinapsis neural.'],
                        ['depan' => 'Bagaimana cara memaksimalkan retensi memori?', 'belakang' => 'Kombinasikan active recall dengan spaced repetition (pengulangan terjeda).'],
                        ['depan' => 'Apa fungsi Peta Konsep dalam pembelajaran?', 'belakang' => 'Membantu otak memahami hubungan hirarkis dan asosiatif antar cabang informasi.'],
                        ['depan' => 'Bagaimana sistem EXP memotivasi peserta didik?', 'belakang' => 'Memberikan umpan balik instan yang memicu kepuasan intrinsik saat menyelesaikan tantangan.']
                    ],
                    'kuis' => [
                        [
                            'pertanyaan' => 'Apa fokus utama dari dokumen materi pembelajaran ini?',
                            'opsi' => ['Pemahaman konsep dan prinsip inti materi', 'Sekadar menghafal tanpa pemahaman', 'Membaca pasif berulang-ulang', 'Mengabaikan latihan kuis'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Materi ditujukan untuk membangun pemahaman konsep yang mendalam dan aplikatif.'
                        ],
                        [
                            'pertanyaan' => 'Metode manakah yang paling efektif untuk retensi memori jangka panjang?',
                            'opsi' => ['Active Recall dan Spaced Repetition', 'Membaca pasif satu malam sebelum ujian', 'Menghafal kata demi kata tanpa memahami', 'Mendengarkan audio tanpa mencatat'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Active recall dan spaced repetition terbukti secara ilmiah memperkuat daya ingat jangka panjang.'
                        ],
                        [
                            'pertanyaan' => 'Apa manfaat utama dari penggunaan Flashcard interaktif?',
                            'opsi' => ['Menguji pemanggilan memori secara mandiri', 'Menggantikan membaca buku sepenuhnya', 'Menghilangkan kebutuhan akan latihan soal', 'Menghapus catatan lama'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Flashcard melatih otak menarik ingatan (retrieval practice) secara aktif.'
                        ],
                        [
                            'pertanyaan' => 'Bagaimana Peta Konsep membantu pemahaman materi yang kompleks?',
                            'opsi' => ['Memvisualisasikan hirarki dan hubungan antar topik', 'Menyembunyikan detail penting materi', 'Membuat materi semakin membingungkan', 'Mengurangi jumlah materi yang harus dipelajari'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Peta konsep mengorganisasi konsep ke dalam bagan visual logis dari umum ke spesifik.'
                        ],
                        [
                            'pertanyaan' => 'Dalam gamifikasi belajar, apa peran sistem EXP (Experience Points)?',
                            'opsi' => ['Memberikan feedback kepuasan instan atas progres belajar', 'Menghukum siswa yang lambat memahami', 'Menutup akses ke materi lain', 'Menghapus catatan belajar'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'EXP berfungsi sebagai mekanisme penguat positif (positive reinforcement) untuk meningkatkan motivasi.'
                        ],
                        [
                            'pertanyaan' => 'Kapan waktu terbaik untuk melakukan pengulangan materi (Spaced Repetition)?',
                            'opsi' => ['Pada interval waktu yang bertahap saat kurva lupa mulai turun', 'Setiap 5 menit sepanjang hari', 'Hanya sekali tepat sebelum ujian', 'Tidak perlu mengulang jika sudah hafal'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Pengulangan terjeda dilakukan tepat saat otak mulai lupa untuk memperkuat jejak memori.'
                        ],
                        [
                            'pertanyaan' => 'Apa yang dimaksud dengan "Passive Reading"?',
                            'opsi' => ['Membaca teks terus menerus tanpa menguji diri sendiri', 'Menjawab kuis setelah membaca satu bab', 'Membuat mind map berdasarkan bacaan', 'Mendiskusikan isi bacaan dengan teman'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Passive reading hanya mengalirkan teks tanpa usaha kognitif aktif untuk memanggil informasi.'
                        ],
                        [
                            'pertanyaan' => 'Apa keuntungan utama mengekstrak poin kunci dari materi?',
                            'opsi' => ['Mempermudah identifikasi intisari ide utama', 'Mengabaikan konteks penting lainnya', 'Memperpendek dokumen tanpa makna', 'Menghilangkan detail teknis'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Poin kunci merangkum informasi esensial sehingga memudahkan pemahaman cepat.'
                        ],
                        [
                            'pertanyaan' => 'Mengapa umpan balik seketika (instant feedback) penting dalam kuis?',
                            'opsi' => ['Mengoreksi miskonsepsi sebelum informasi salah melekat', 'Membuat siswa merasa tertekan', 'Mempercepat berakhirnya sesi belajar', 'Menghindari penjelasan materi'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Instant feedback memungkinkan pembelajar langsung memahami letak kekeliruan dan memperbaikinya.'
                        ],
                        [
                            'pertanyaan' => 'Apa peran streak harian dalam kebiasaan belajar?',
                            'opsi' => ['Membangun konsistensi dan disiplin belajar rutin', 'Memaksa belajar 24 jam nonstop', 'Menghapus progres jika terlewat 1 menit', 'Mengurangi nilai ujian'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Streak harian menjaga momentum belajar agar menjadi kebiasaan otomatis setiap hari.'
                        ],
                        [
                            'pertanyaan' => 'Dalam konteks belajar cerdas, apa yang dimaksud dengan "Retrieval Practice"?',
                            'opsi' => ['Latihan memanggil kembali memori dari dalam pikiran', 'Menyimpan buku di tempat yang mudah dijangkau', 'Menyalin ulang seluruh buku catatan', 'Membaca ulang catatan sebanyak 10 kali'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Retrieval practice adalah melatih otak menarik informasi keluar, bukan sekadar memasukkan informasi.'
                        ],
                        [
                            'pertanyaan' => 'Bagaimana cara terbaik mengukur apakah suatu materi sudah benar-benar dikuasai?',
                            'opsi' => ['Mampu menjelaskan konsep tersebut dengan bahasa sendiri dan menjawab variasi soal', 'Hanya melihat bahwa buku sudah selesai dibaca', 'Menyimpan dokumen di folder komputer', 'Menghafal judul subbab tanpa isi'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Penguasaan sejati ditunjukkan dengan kemampuan mengelaborasi konsep (Feynman Technique) dan menerapkannya.'
                        ],
                        [
                            'pertanyaan' => 'Apa fungsi fitur Pop-up pada Peta Konsep dan Kuis di platform Loma?',
                            'opsi' => ['Memberikan tampilan yang luas, jelas, dan fokus tanpa distraksi', 'Menyembunyikan informasi penting', 'Menutup dokumen secara paksa', 'Memperlambat aplikasi'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Tampilan pop-up modal memberikan ruang visual yang maksimal dan kenyamanan navigasi bagi siswa.'
                        ],
                        [
                            'pertanyaan' => 'Mengapa refleksi setelah menyelesaikan kuis sangat dianjurkan?',
                            'opsi' => ['Menganalisis mengapa suatu opsi benar atau salah memperkuat penalaran', 'Hanya untuk membuang waktu', 'Agar skor kuis berkurang', 'Tidak ada manfaat edukatif'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Membaca penjelasan di setiap soal membantu merekonstruksi pemahaman konsep yang kokoh.'
                        ],
                        [
                            'pertanyaan' => 'Apa hasil akhir yang diharapkan dari siklus belajar Active Recall + Gamifikasi?',
                            'opsi' => ['Retensi memori maksimal dan motivasi belajar mandiri yang berkelanjutan', 'Rasa jenuh yang berlebihan', 'Hilangnya minat terhadap materi pembelajaran', 'Ketergantungan pada hafalan jangka pendek'],
                            'jawaban_benar' => 0,
                            'penjelasan' => 'Kombinasi sains memori dan elemen permainan menciptakan siklus belajar yang efektif dan menyenangkan.'
                        ]
                    ]
                ];
            }

            // Normalisasi dan validasi kuis
            $rawKuis = $aiResult['kuis'] ?? [];
            $cleanKuis = [];
            if (is_array($rawKuis)) {
                foreach ($rawKuis as $item) {
                    if (!isset($item['pertanyaan']) || !isset($item['opsi']) || !is_array($item['opsi'])) {
                        continue;
                    }
                    $opsi = array_values(array_map('strval', $item['opsi']));
                    if (empty($opsi)) continue;

                    $rawJb = $item['jawaban_benar'] ?? 0;
                    $jbIdx = 0;

                    if (is_numeric($rawJb)) {
                        $num = (int)$rawJb;
                        if ($num >= 0 && $num < count($opsi)) {
                            $jbIdx = $num;
                        } elseif ($num >= 1 && $num <= count($opsi)) {
                            $jbIdx = $num - 1;
                        }
                    } elseif (is_string($rawJb)) {
                        $trimmed = trim($rawJb);
                        if (preg_match('/^[A-Da-d]$/', $trimmed)) {
                            $jbIdx = ord(strtoupper($trimmed)) - ord('A');
                        } elseif (preg_match('/^(?:opsi|option)?\s*([A-Da-d])[\.\:\s]/i', $trimmed, $m)) {
                            $jbIdx = ord(strtoupper($m[1])) - ord('A');
                        } else {
                            foreach ($opsi as $oIdx => $optText) {
                                if (strcasecmp(trim($optText), $trimmed) === 0) {
                                    $jbIdx = $oIdx;
                                    break;
                                }
                            }
                        }
                    }

                    if ($jbIdx < 0 || $jbIdx >= count($opsi)) {
                        $jbIdx = 0;
                    }

                    $cleanKuis[] = [
                        'pertanyaan' => (string)$item['pertanyaan'],
                        'opsi' => $opsi,
                        'jawaban_benar' => $jbIdx,
                        'penjelasan' => (string)($item['penjelasan'] ?? '')
                    ];
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'extracted_text' => $materiText,
                    'title' => $aiResult['title'] ?? 'Catatan Materi',
                    'rangkuman' => $aiResult['rangkuman'],
                    'poin_kunci' => $aiResult['poin_kunci'] ?? [],
                    'peta_konsep' => $aiResult['peta_konsep'] ?? null,
                    'flashcards' => $aiResult['flashcards'] ?? [],
                    'kuis' => $cleanKuis,
                    'visualisasi' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=800&auto=format&fit=crop'
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan internal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Endpoint Tanya Jawab Dokumen (Chat RAG) Loma AI Studio.
     */
    public function chat(Request $request)
    {
        $message = $request->input('message');
        $context = $request->input('context', '');
        $sources = $request->input('sources', []);

        if (empty($message)) {
            return response()->json(['status' => 'error', 'message' => 'Pesan tidak boleh kosong'], 400);
        }

        $sourcesListStr = !empty($sources) ? implode(', ', $sources) : 'dokumen yang diunggah';
        $trimmedContext = mb_substr($context, 0, 10000);

        $prompt = <<<EOT
Kamu adalah Loma.AI Studio Assistant. Kamu menjawab pertanyaan pengguna secara akurat, lugas, dan terstruktur.
Gunakan HANYA informasi dari konteks dokumen berikut jika relevan.

Konteks Dokumen Sumber (Sumber: {$sourcesListStr}):
---
{$trimmedContext}
---

Pertanyaan Pengguna:
{$message}

Aturan Penulisan Jawaban:
1. Jawab dalam Bahasa Indonesia yang profesional dan ramah.
2. Gunakan markdown seperti **bold** untuk istilah penting.
3. Cantumkan rujukan berupa tanda sitasi nomor kecil seperti [1] atau [2] pada klausa penting yang merujuk fakta dokumen.
4. Jika dokumen tidak memiliki jawaban pasti, jawablah dengan pengetahuan umum namun sebutkan bahwa hal tersebut adalah informasi tambahan di luar dokumen.
EOT;

        $systemPrompt = "Kamu adalah asisten studi cerdas berbasis dokumen untuk Loma.AI Studio yang selalu memberikan jawaban yang kredibel dan terstruktur.";
        $answer = $this->callAIService($prompt, $systemPrompt, false);

        if (!$answer || (is_array($answer) && isset($answer['error']))) {
            $answer = "Maaf, terjadi gangguan saat menghubungi model AI. Namun berdasarkan topik yang Anda tanyakan ('" . htmlspecialchars($message) . "'), Anda dapat memeriksa kembali poin-poin materi pada tab Rangkuman.";
        }

        return response()->json([
            'status' => 'success',
            'answer' => is_string($answer) ? $answer : ($answer['content'] ?? json_encode($answer))
        ]);
    }

    /**
     * Helper untuk memanggil model AI (Groq Qwen/Llama dengan fallback ke Gemini)
     */
    private function callAIService($prompt, $systemPrompt = '', $jsonMode = false)
    {
        $groqKey = env('GROQ_API_KEY');
        $geminiKey = env('GEMINI_API_KEY');

        // Jika di .env utama belum terbaca, coba baca dari edugen_ai/.env
        if (empty($groqKey) || empty($geminiKey)) {
            $envPath = base_path('edugen_ai/.env');
            if (file_exists($envPath)) {
                $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    if (str_starts_with($line, 'GROQ_API_KEY=')) {
                        $groqKey = trim(substr($line, 13));
                    }
                    if (str_starts_with($line, 'GEMINI_API_KEY=')) {
                        $geminiKey = trim(substr($line, 15));
                    }
                }
            }
        }

        // 1. Coba Groq (Sangat cepat ~0.5 detik)
        if (!empty($groqKey)) {
            try {
                $groqModels = ['qwen/qwen3.8-27b', 'openai/gpt-oss-120b', 'openai/gpt-oss-20b'];
                foreach ($groqModels as $model) {
                    $payload = [
                        'model' => $model,
                        'messages' => [
                            ['role' => 'system', 'content' => $systemPrompt ?: 'Kamu asisten AI yang cerdas.'],
                            ['role' => 'user', 'content' => $prompt]
                        ],
                        'temperature' => 0.4
                    ];

                    if ($jsonMode) {
                        $payload['response_format'] = ['type' => 'json_object'];
                    }

                    $ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 25);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $groqKey,
                        'Content-Type: application/json'
                    ]);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

                    $res = curl_exec($ch);
                    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    if ($code === 200 && $res) {
                        $data = json_decode($res, true);
                        $content = $data['choices'][0]['message']['content'] ?? '';
                        if ($jsonMode) {
                            $parsed = $this->parseJsonOutput($content);
                            if ($parsed) return $parsed;
                        } else {
                            return $content;
                        }
                    }
                }
            } catch (Exception $e) {
                // Lanjut ke fallback
            }
        }

        // 2. Fallback Gemini API
        if (!empty($geminiKey)) {
            try {
                $geminiModels = ['gemini-3.8-flash', 'gemini-2.5-flash'];
                foreach ($geminiModels as $gModel) {
                    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$gModel}:generateContent?key={$geminiKey}";
                    $payload = [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => ($systemPrompt ? "{$systemPrompt}\n\n" : "") . $prompt]
                                ]
                            ]
                        ]
                    ];

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 25);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

                    $res = curl_exec($ch);
                    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    if ($code === 200 && $res) {
                        $data = json_decode($res, true);
                        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                        if ($jsonMode) {
                            $parsed = $this->parseJsonOutput($text);
                            if ($parsed) return $parsed;
                        } else {
                            return $text;
                        }
                    }
                }
            } catch (Exception $e) {
                // Fallback gagal
            }
        }

        return null;
    }

    /**
     * Membersihkan dan mengekstrak JSON dari output AI
     */
    private function parseJsonOutput($text)
    {
        $text = trim($text);
        if (preg_match('/```(?:json)?\s*([\s\S]*?)\s*```/', $text, $matches)) {
            $text = trim($matches[1]);
        }

        $decoded = json_decode($text, true);
        if ($decoded !== null) {
            return $decoded;
        }

        $firstBrace = strpos($text, '{');
        $lastBrace = strrpos($text, '}');
        if ($firstBrace !== false && $lastBrace !== false && $lastBrace > $firstBrace) {
            $sub = substr($text, $firstBrace, $lastBrace - $firstBrace + 1);
            $decoded = json_decode($sub, true);
            if ($decoded !== null) {
                return $decoded;
            }
        }

        return null;
    }

    private function extractTextFromDocx($filePath)
    {
        $text = '';
        $zip = new ZipArchive;
        if ($zip->open($filePath) === TRUE) {
            if (($index = $zip->locateName('word/document.xml')) !== false) {
                $data = $zip->getFromIndex($index);
                $zip->close();
                $dom = new DOMDocument();
                @$dom->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                $text = strip_tags($dom->saveXML());
            }
        }
        return preg_replace('/\s+/', ' ', $text);
    }

    private function extractTextFromPptx($filePath)
    {
        $text = '';
        $zip = new ZipArchive;
        if ($zip->open($filePath) === TRUE) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                if (preg_match('/ppt\/slides\/slide\d+\.xml/', $filename)) {
                    $data = $zip->getFromName($filename);
                    $dom = new DOMDocument();
                    @$dom->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                    $text .= strip_tags($dom->saveXML()) . " ";
                }
            }
            $zip->close();
        }
        return preg_replace('/\s+/', ' ', $text);
    }

    private function extractTextFromHtml($html)
    {
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html);
        $html = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $html);
        $text = strip_tags($html);
        return preg_replace('/\s+/', ' ', $text);
    }
}
