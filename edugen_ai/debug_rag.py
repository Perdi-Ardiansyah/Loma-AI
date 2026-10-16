import json
from pathlib import Path

import faiss
from sentence_transformers import SentenceTransformer

KNOWLEDGE_DIR = Path("knowledge")

TOP_K = 10

print("Memuat database...")

index = faiss.read_index(
    str(KNOWLEDGE_DIR / "index.faiss")
)

with open(
    KNOWLEDGE_DIR / "chunks.json",
    "r",
    encoding="utf-8"
) as f:
    chunks = json.load(f)

print("Memuat model embedding...")

embedding_model = SentenceTransformer(
    "sentence-transformers/paraphrase-multilingual-MiniLM-L12-v2"
)

question = input("\nPertanyaan: ")

query_vector = embedding_model.encode(
    [question],
    convert_to_numpy=True,
    normalize_embeddings=True
)

scores, indices = index.search(
    query_vector,
    TOP_K
)

print("\n" + "=" * 80)
print("HASIL PENCARIAN RAG")
print("=" * 80)

for rank, (score, idx) in enumerate(
    zip(scores[0], indices[0]),
    start=1
):

    if idx < 0:
        continue

    item = chunks[idx]

    print(f"\n--- HASIL {rank} ---")
    print(f"Skor   : {score:.4f}")
    print(f"Halaman: {item['page']}")
    print(f"Sumber : {item['source']}")

    print("\nIsi:")
    print(item["text"][:1000])

    print("\n" + "-" * 80)