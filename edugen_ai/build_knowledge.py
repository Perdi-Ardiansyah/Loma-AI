import fitz  # PyMuPDF
import json
import os
import faiss
from sentence_transformers import SentenceTransformer

BOOK_FILE = "books/ipa_kelas_7.pdf"
KNOWLEDGE_DIR = "knowledge_base"

BOOK_META = {
    "book": "Ilmu Pengetahuan Alam untuk SMP/MTs Kelas VII",
    "grade": "VII",
    "subject": "IPA"
}

# Mapping manual nomor halaman PDF (dimulai dari 1)
CHAPTER_MAP = {
    "Bab 1 - Hakikat Ilmu Sains dan Metode Ilmiah": (13, 40),
    "Bab 2 - Zat dan Perubahannya": (41, 75),
    "Bab 3 - Suhu, Kalor dan Pemuaian": (76, 105),
}

def get_chapter(page_num):
    for chapter, (start, end) in CHAPTER_MAP.items():
        if start <= page_num <= end:
            return chapter
    return "Lainnya"

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

def main():
    print(f"Membaca PDF: {BOOK_FILE}")
    doc = fitz.open(BOOK_FILE)
    
    chunks_data = []
    chunk_id = 0
    
    for page_num in range(len(doc)):
        actual_page = page_num + 1
        text = doc[page_num].get_text("text").strip()
        
        if not text or len(text) < 50: continue
            
        chapter = get_chapter(actual_page)
        source_type = "metadata" if chapter == "Lainnya" else "textbook_body"
            
        for t_chunk in chunk_text(text):
            if len(t_chunk.split()) < 10: continue
            chunks_data.append({
                "id": chunk_id,
                "book": BOOK_META["book"],
                "grade": BOOK_META["grade"],
                "subject": BOOK_META["subject"],
                "chapter": chapter,
                "page": actual_page,
                "text": t_chunk,
                "source_type": source_type
            })
            chunk_id += 1

    print(f"Total {len(chunks_data)} chunks. Memuat model embedding CPU...")
    embedder = SentenceTransformer("sentence-transformers/paraphrase-multilingual-MiniLM-L12-v2")
    
    texts = [c["text"] for c in chunks_data]
    embeddings = embedder.encode(texts, convert_to_numpy=True, show_progress_bar=True)
    
    dimension = embeddings.shape[1]
    index = faiss.IndexFlatL2(dimension)
    index.add(embeddings)
    
    os.makedirs(KNOWLEDGE_DIR, exist_ok=True)
    faiss.write_index(index, f"{KNOWLEDGE_DIR}/index.faiss")
    with open(f"{KNOWLEDGE_DIR}/chunks.json", "w", encoding="utf-8") as f:
        json.dump(chunks_data, f, ensure_ascii=False, indent=4)
        
    print("Knowledge Base siap!")

if __name__ == "__main__":
    main()