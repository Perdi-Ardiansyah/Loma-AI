from fastapi import FastAPI, HTTPException, UploadFile, File
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import HTMLResponse
from pydantic import BaseModel
import os
import shutil
import json

from generator import EduGenCloud
from knowledge_manager import process_uploaded_book

app = FastAPI(title="EduGen AI API")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"], 
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

edugen_service = EduGenCloud()

class GenerateRequest(BaseModel):
    grade: str
    subject: str
    chapter: str
    content_type: str = "kuis"
    count: int = 15
    difficulty: str = "sedang"
    summary_context: str = None  # TAMBAHAN BARU: Untuk menyimpan teks rangkuman

@app.post("/api/generate")
async def generate_content(request: GenerateRequest):
    try:
        # Refresh database memori setiap kali ingin membuat soal
        edugen_service.retriever.__init__()
        
        result = edugen_service.generate(
            grade=request.grade, subject=request.subject, chapter=request.chapter,
            content_type=request.content_type, count=request.count, difficulty=request.difficulty,
            summary_context=request.summary_context
        )
        if isinstance(result, dict) and "error" in result:
            raise HTTPException(status_code=400, detail=result["error"])
        return result
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Terjadi kesalahan internal: {str(e)}")

@app.post("/api/upload-book")
async def upload_book(file: UploadFile = File(...)):
    os.makedirs("books", exist_ok=True)
    file_path = f"books/{file.filename}"
    
    with open(file_path, "wb") as buffer:
        shutil.copyfileobj(file.file, buffer)
        
    try:
        hasil = process_uploaded_book(file_path)
        if hasil["status"] == "gagal":
            raise HTTPException(status_code=400, detail=hasil["message"])
        return hasil
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Gagal memproses buku: {str(e)}")

@app.get("/api/available-books")
async def get_available_books():
    json_path = "knowledge_base/chunks.json"
    if not os.path.exists(json_path):
        return {}
        
    try:
        with open(json_path, "r", encoding="utf-8") as f:
            chunks = json.load(f)
            
        books = {}
        for c in chunks:
            title = c.get("book", "Tanpa Judul")
            if title not in books:
                books[title] = {
                    "grade": c.get("grade", "Umum"),
                    "subject": c.get("subject", "Umum"),
                    "chapters": set()
                }
            books[title]["chapters"].add(c.get("chapter"))
            
        for title in books:
            books[title]["chapters"] = sorted(list(books[title]["chapters"]))
            
        return books
    except Exception as e:
        return {}

@app.get("/", response_class=HTMLResponse)
async def serve_ui():
    if os.path.exists("index.html"):
        with open("index.html", "r", encoding="utf-8") as f:
            return f.read()
    return "File index.html tidak ditemukan."