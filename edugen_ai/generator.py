import os
import json
import re
from PIL import Image
import google.generativeai as genai
from dotenv import load_dotenv
from retriever import HybridRetriever

load_dotenv()
genai.configure(api_key=os.getenv("GEMINI_API_KEY"))

class EduGenCloud:
    def __init__(self):
        self.retriever = HybridRetriever()

    def extract_json(self, text):
        match = re.search(r'```(?:json)?(.*?)```', text, re.DOTALL)
        if match: text = match.group(1).strip()
        try: return json.loads(text.strip())
        except:
            start = text.find('{')
            end = text.rfind('}')
            if start != -1 and end != -1:
                try: return json.loads(text[start:end+1])
                except: pass
            return {"error": "Gagal parsing JSON dari output AI", "raw": text}

    def get_chapter_images(self, chapter):
        images = []
        try:
            with open("knowledge_base/chunks.json", "r", encoding="utf-8") as f:
                chunks = json.load(f)
            for c in chunks:
                if c.get("chapter") == chapter:
                    for img_path in c.get("images", []):
                        if img_path not in images and os.path.exists(img_path):
                            images.append(img_path)
        except: pass
        return images

    def generate(self, grade, subject, chapter, content_type="kuis", count=15, difficulty="sedang", summary_context=None):
        # 1. Tentukan Konteks secara Dinamis
        if summary_context:
            # Jika membuat soal dari rangkuman
            context = f"[SUMBER UTAMA: RANGKUMAN MATERI]\n{summary_context}"
            
        elif content_type == "ringkasan":
            # PERBAIKAN: Ambil langsung semua teks dari database tanpa filter kemiripan FAISS
            try:
                with open("knowledge_base/chunks.json", "r", encoding="utf-8") as f:
                    chunks = json.load(f)
                
                # Tarik semua paragraf yang cocok dengan bab ini
                chapter_texts = [c["text"] for c in chunks if c.get("chapter") == chapter and str(c.get("grade")) == str(grade) and c.get("subject") == subject]
                
                if not chapter_texts:
                    return {"error": f"Konteks kosong untuk Bab: {chapter}. Pastikan buku berhasil diekstrak."}
                    
                # Gabungkan teks (Batasi ~15000 karakter agar API Gemini tidak overload)
                context = "\n\n".join(chapter_texts)[:15000]
            except Exception as e:
                return {"error": f"Gagal membaca memori: {e}"}
                
        else:
            # Pencarian standar (sebagai cadangan jika bukan kuis dari rangkuman)
            rag_result = self.retriever.retrieve("konsep materi", grade, subject, chapter)
            if rag_result.get("error"): return {"error": rag_result["message"]}
            context = rag_result["context_string"]
            
        # 2. Muat Gambar Multimodal
        image_paths = self.get_chapter_images(chapter)
        pil_images = []
        for path in image_paths[:15]: 
            try: pil_images.append(Image.open(path))
            except: pass

        # 3. Penyesuaian Instruksi
        if content_type == "kuis" or content_type == "soal":
            instruction = (f"Buat kuis berisi {count} soal pilihan ganda tingkat {difficulty}. "
                           "Schema JSON WAJIB: objek dengan key 'multiple_choice' yang berisi array of { question, options: {A,B,C,D}, answer, explanation }")
        elif content_type == "ringkasan":
            instruction = ("Buat ringkasan materi yang sangat detail dan padat. Jika ada informasi penting dari gambar/grafik yang dilampirkan, masukkan ke dalam rangkuman teks. "
                           "Schema JSON WAJIB: objek berisi { 'title', 'summary', 'key_points': [], 'key_terms': [] }")
        elif content_type == "uts":
            instruction = (f"Buat paket UTS dengan {count} PG dan esai tingkat {difficulty}. "
                           "Schema JSON WAJIB: objek dengan key 'title', 'instructions', 'multiple_choice', dan 'essay'")
        else:
            instruction = "Format output harus JSON murni."

        prompt = f"""Konteks Materi ({subject} Kelas {grade} - {chapter}):\n{context}\n\nTugas:\n{instruction}

ATURAN MUTLAK:
1. Jika materi ini berhubungan dengan gambar/grafik yang dilampirkan, bahaslah informasinya.
2. DILARANG KERAS menuliskan kata referensi "halaman" atau "buku" di dalam pertanyaan.
3. Keluarkan HANYA format JSON murni."""

        contents = [prompt] + pil_images
        
        try:
            model = genai.GenerativeModel('gemini-3.8-flash')
            response = model.generate_content(contents)
            return self.extract_json(response.text)
        except Exception as e:
            groq_key = os.getenv("GROQ_API_KEY")
            if groq_key:
                try:
                    import requests
                    headers = {"Authorization": f"Bearer {groq_key}", "Content-Type": "application/json"}
                    payload = {
                        "model": "qwen/qwen3.8-27b",
                        "messages": [
                            {"role": "system", "content": "Keluarkan HANYA format JSON murni."},
                            {"role": "user", "content": prompt}
                        ],
                        "response_format": {"type": "json_object"},
                        "temperature": 0.4
                    }
                    g_res = requests.post("https://api.groq.com/openai/v1/chat/completions", headers=headers, json=payload, timeout=20)
                    if g_res.status_code == 200:
                        content = g_res.json()["choices"][0]["message"]["content"]
                        return self.extract_json(content)
                except Exception:
                    pass
            return {"error": f"Gagal menghasilkan konten dari AI: {e}"}