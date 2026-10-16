import pymupdf as fitz  # PyMuPDF
import json
import os
import faiss
import re
import io
from PIL import Image
import google.generativeai as genai
from sentence_transformers import SentenceTransformer
from dotenv import load_dotenv

load_dotenv()
genai.configure(api_key=os.getenv("GEMINI_API_KEY"))

KNOWLEDGE_DIR = "knowledge_base"
print("[Knowledge Manager] Memuat model embedding...")
embedder = SentenceTransformer("sentence-transformers/paraphrase-multilingual-MiniLM-L12-v2")

def extract_metadata_with_ai(file_path):
    print(f"[Metadata AI] Menganalisis metadata untuk: {file_path}")
    try:
        doc = fitz.open(file_path)
        text = "".join([doc[i].get_text("text") + "\n" for i in range(min(5, len(doc)))])
            
        model = genai.GenerativeModel('gemini-1.5-flash')
        prompt = f"""Analisis teks awal dari dokumen buku pendidikan ini.
Teks: {text[:3000]}
Tugas: Temukan Judul Buku, Kelas (angka 1-12), dan Mata Pelajaran.
Keluarkan HANYA format JSON murni: {{"title": "Judul Buku", "grade": "Angka", "subject": "Mapel"}}"""

        response = model.generate_content(prompt)
        out = response.text.strip()
        if out.startswith("```json"): out = out[7:]
        if out.endswith("```"): out = out[:-3]
        return json.loads(out.strip())
    except:
        return {"title": os.path.basename(file_path), "grade": "Umum", "subject": "Umum"}

def chunk_text(text, max_words=150):
    words = text.split()
    if len(words) <= max_words: return [text]
    chunks, current = [], []
    for word in words:
        current.append(word)
        if len(current) >= max_words and word.endswith('.'):
            chunks.append(" ".join(current))
            current = []
    if current: chunks.append(" ".join(current))
    return chunks

def process_uploaded_book(file_path):
    metadata = extract_metadata_with_ai(file_path)
    book_title = metadata.get("title", "Buku Tanpa Judul")
    grade = str(metadata.get("grade", "Umum"))
    subject = metadata.get("subject", "Umum")
    
    doc = fitz.open(file_path)
    toc = doc.get_toc()
    
    chunks_data = []
    index_path = f"{KNOWLEDGE_DIR}/index.faiss"
    json_path = f"{KNOWLEDGE_DIR}/chunks.json"
    
    if os.path.exists(json_path):
        with open(json_path, "r", encoding="utf-8") as f:
            chunks_data = json.load(f)
            
    chunk_id = len(chunks_data)
    new_texts = []
    
    toc_dict = {}
    for item in toc:
        if item[0] == 1: 
            clean_title = re.sub(r'\s+', ' ', item[1].strip())
            if len(clean_title) < 100: toc_dict[item[2]] = clean_title
                
    has_valid_toc = len(toc_dict) > 0
    current_chapter = "Semua Materi"
    
    for page_num in range(len(doc)):
        actual_page = page_num + 1
        page_obj = doc[page_num]
        text = page_obj.get_text("text").strip()
        
        # --- FITUR BARU: EKSTRAK GAMBAR ---
        page_images = []
        for img_idx, img_info in enumerate(page_obj.get_images(full=True)):
            try:
                xref = img_info[0]
                base_image = doc.extract_image(xref)
                image_bytes = base_image["image"]
                img_ext = base_image["ext"]
                
                # Filter: Hanya simpan gambar besar (mungkin grafik/diagram), abaikan ikon kecil
                img_obj = Image.open(io.BytesIO(image_bytes))
                if img_obj.width >= 150 and img_obj.height >= 150:
                    img_dir = f"{KNOWLEDGE_DIR}/images"
                    os.makedirs(img_dir, exist_ok=True)
                    safe_title = "".join(c for c in book_title if c.isalnum()).strip()
                    img_filename = f"{img_dir}/{safe_title}_p{actual_page}_{img_idx}.{img_ext}"
                    with open(img_filename, "wb") as f:
                        f.write(image_bytes)
                    page_images.append(img_filename)
            except: pass
        # ----------------------------------

        if not text or len(text) < 50: continue
        
        if has_valid_toc:
            if actual_page in toc_dict: current_chapter = toc_dict[actual_page]
        else:
            lines = [line.strip() for line in text.split('\n') if line.strip()]
            for i, line in enumerate(lines[:5]):
                if re.match(r"(?i)^(BAB|CHAPTER|UNIT)\s+([IVX]+|\d+)\b", line) and len(line) < 80:
                    temp_chapter = line
                    if len(line) < 15 and i + 1 < len(lines):
                        if len(lines[i+1]) < 80 and "kementerian" not in lines[i+1].lower():
                            temp_chapter += " - " + lines[i+1]
                    current_chapter = re.sub(r'\s+', ' ', temp_chapter)
                    break
            
        for t_chunk in chunk_text(text):
            if len(t_chunk.split()) < 10: continue
            
            chunks_data.append({
                "id": chunk_id,
                "book": book_title,
                "grade": grade,
                "subject": subject,
                "chapter": current_chapter,
                "page": actual_page,
                "text": t_chunk,
                "images": page_images # Simpan referensi gambar ke memori!
            })
            new_texts.append(t_chunk)
            chunk_id += 1

    if not new_texts: return {"status": "gagal", "message": "Tidak ada teks yang diekstrak."}

    new_embeddings = embedder.encode(new_texts, convert_to_numpy=True)
    
    if os.path.exists(index_path):
        index = faiss.read_index(index_path)
        index.add(new_embeddings)
    else:
        os.makedirs(KNOWLEDGE_DIR, exist_ok=True)
        index = faiss.IndexFlatL2(new_embeddings.shape[1])
        index.add(new_embeddings)
        
    faiss.write_index(index, index_path)
    with open(json_path, "w", encoding="utf-8") as f:
        json.dump(chunks_data, f, ensure_ascii=False, indent=4)
        
    return {"status": "sukses", "message": f"Berhasil! Buku {book_title} selesai dibaca (termasuk gambarnya)."}