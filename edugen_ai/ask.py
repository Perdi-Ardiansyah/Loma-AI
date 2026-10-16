
import json
from pathlib import Path

import faiss
import torch
from sentence_transformers import SentenceTransformer
from transformers import AutoTokenizer, AutoModelForCausalLM
from peft import PeftModel

# Konfigurasi
BASE_MODEL = "Qwen/Qwen2.5-0.5B-Instruct"
ADAPTER = "./edugen_model"
KNOWLEDGE_DIR = Path("knowledge")
TOP_K = 3

# Memuat database buku
print("Memuat database...")
index = faiss.read_index(str(KNOWLEDGE_DIR / "index.faiss"))

with open(KNOWLEDGE_DIR / "chunks.json", "r", encoding="utf-8") as f:
    chunks = json.load(f)

# Memuat model embedding
print("Memuat model pencarian...")
embedding_model = SentenceTransformer(
    "sentence-transformers/paraphrase-multilingual-MiniLM-L12-v2"
)

# Memuat model hasil fine-tuning
print("Memuat model Qwen...")
tokenizer = AutoTokenizer.from_pretrained(ADAPTER)

base_model = AutoModelForCausalLM.from_pretrained(
    BASE_MODEL,
    dtype=torch.float32
)

model = PeftModel.from_pretrained(base_model, ADAPTER)
model.eval()


def search_book(question):
    query_vector = embedding_model.encode(
        [question],
        convert_to_numpy=True,
        normalize_embeddings=True
    )

    scores, indices = index.search(query_vector, TOP_K)

    results = []
    for score, idx in zip(scores[0], indices[0]):
        if idx < 0:
            continue
        results.append({
            "text": chunks[idx]["text"],
            "page": chunks[idx]["page"],
            "score": float(score)
        })

    return results  


def ask_ai(question):
    results = search_book(question)

    context = "\n\n".join(
        f"[Halaman {item['page']}]\n{item['text']}"
        for item in results
    )


    messages = [
        {
            "role": "system",
            "content": (
                "Kamu adalah EduGen AI, asisten pendidikan untuk siswa "
                "Indonesia. Tugasmu membuat soal dan jawaban berdasarkan "
                "materi buku yang diberikan.\n\n"
                "ATURAN WAJIB:\n"
                "1. Ikuti jumlah soal yang diminta pengguna secara tepat.\n"
                "2. Gunakan hanya materi yang tersedia dalam konteks.\n"
                "3. Setiap soal harus memiliki jawaban yang jelas dan benar.\n"
                "4. Jangan membuat jawaban yang tidak didukung materi.\n"
                "5. Gunakan bahasa Indonesia yang sederhana dan baku.\n"
                "6. Jangan menambahkan soal di luar jumlah yang diminta.\n"
                "7. Jika materi tidak cukup, jelaskan keterbatasannya.\n"
                "8. Jangan mengulang pertanyaan yang sama."
            )
        },
        {
            "role": "user",
            "content": (
                f"Buat tepat 3 soal IPA kelas 7 berdasarkan materi berikut.\n"
                f"Setiap soal harus disertai jawaban.\n\n"
                f"Materi buku:\n{context}\n\n"
                "Gunakan format:\n"
                "1. Soal: ...\n"
                "   Jawaban: ...\n"
                "2. Soal: ...\n"
                "   Jawaban: ...\n"
                "3. Soal: ...\n"
                "   Jawaban: ...\n"
            )
        }
    ]

    prompt = tokenizer.apply_chat_template(
        messages,
        tokenize=False,
        add_generation_prompt=True
    )

    inputs = tokenizer(prompt, return_tensors="pt")

    with torch.no_grad():
        outputs = model.generate(
            **inputs,
            max_new_tokens=300,
            do_sample=False,
            pad_token_id=tokenizer.eos_token_id
        )

    answer = outputs[0][inputs["input_ids"].shape[1]:]
    return tokenizer.decode(answer, skip_special_tokens=True), results


if __name__ == "__main__":
    print("\nEduGen AI siap digunakan!")
    print("Ketik 'keluar' untuk berhenti.\n")

    while True:
        question = input("Kamu: ").strip()

        if question.lower() == "keluar":
            break

        if not question:
            continue

        answer, sources = ask_ai(question)

        print("\nEduGen AI:")
        print(answer)

        print("\nSumber materi:")
        for source in sources:
            print(f"- Halaman {source['page']} "
                  f"(skor: {source['score']:.3f})")

        print()