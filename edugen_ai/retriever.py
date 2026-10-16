import json
import torch
from sentence_transformers import SentenceTransformer, util

class HybridRetriever:
    def __init__(self, metadata_path="knowledge_base/chunks.json"):
        with open(metadata_path, "r", encoding="utf-8") as f:
            self.all_chunks = json.load(f)
        self.embedder = SentenceTransformer("sentence-transformers/paraphrase-multilingual-MiniLM-L12-v2")

    def retrieve(self, query, grade, subject, chapter, top_k=4, relevance_weight=0.6):
        """
        relevance_weight (0.0 - 1.0): 
        - 1.0 berarti fokus 100% pada relevansi (sama seperti Semantic Search biasa).
        - 0.5 berarti seimbang antara mencari yang relevan dan mencari yang bervariasi.
        - 0.6 adalah titik imbang yang optimal untuk materi edukasi.
        """
        # 1. Hard Filter
        filtered_chunks = [
            c for c in self.all_chunks 
            if c.get("source_type") == "textbook_body"
            and c.get("grade") == grade 
            and c.get("subject") == subject 
            and chapter.lower() in c.get("chapter", "").lower()
        ]

        if not filtered_chunks:
            return {"error": True, "message": f"Konteks kosong untuk Bab: {chapter}."}

        # 2. Siapkan Embedding
        corpus_texts = [c["text"] for c in filtered_chunks]
        corpus_embeddings = self.embedder.encode(corpus_texts, convert_to_tensor=True)
        query_embedding = self.embedder.encode(query, convert_to_tensor=True)

        # 3. Hitung Matriks Kemiripan
        # Kemiripan antara query dan semua dokumen (N,)
        query_sim = util.cos_sim(query_embedding, corpus_embeddings)[0]
        # Kemiripan antar-semua dokumen dalam corpus (N, N)
        doc_sim = util.cos_sim(corpus_embeddings, corpus_embeddings)

        selected_indices = []
        unselected_indices = list(range(len(corpus_embeddings)))

        # 4. Algoritma Maximal Marginal Relevance (MMR)
        for _ in range(min(top_k, len(corpus_embeddings))):
            if not selected_indices:
                # Pilihan pertama selalu dokumen yang paling relevan dengan kueri
                best_idx = unselected_indices[torch.argmax(query_sim[unselected_indices]).item()]
            else:
                best_score = -float('inf')
                best_idx = -1
                
                for idx in unselected_indices:
                    # Skor Relevansi terhadap query
                    rel_score = query_sim[idx].item()
                    
                    # Skor Penalti: Kemiripan tertinggi dengan dokumen yang SUDAH terpilih
                    sim_to_selected = torch.max(doc_sim[idx, selected_indices]).item()
                    
                    # Formula MMR
                    mmr_score = (relevance_weight * rel_score) - ((1 - relevance_weight) * sim_to_selected)
                    
                    if mmr_score > best_score:
                        best_score = mmr_score
                        best_idx = idx
            
            selected_indices.append(best_idx)
            unselected_indices.remove(best_idx)

        # 5. Susun Hasil
        context_parts = []
        for idx in selected_indices:
            chunk = filtered_chunks[idx]
            context_parts.append(f"[Halaman {chunk['page']}]\n{chunk['text']}")
            
        return {
            "error": False,
            "context_string": "\n\n".join(context_parts)
        }