
import torch
from transformers import AutoTokenizer, AutoModelForCausalLM
from peft import PeftModel

BASE_MODEL = "Qwen/Qwen2.5-0.5B-Instruct"
ADAPTER = "./edugen_model"

tokenizer = AutoTokenizer.from_pretrained(ADAPTER)

base = AutoModelForCausalLM.from_pretrained(
    BASE_MODEL,
    torch_dtype=torch.float32
)

model = PeftModel.from_pretrained(base, ADAPTER)
model.eval()

messages = [
    {
        "role": "system",
        "content": "Kamu adalah asisten pendidikan."
    },
    {
        "role": "user",
        "content": (
            "Buat satu soal pilihan ganda berdasarkan materi ini: "
            "Fotosintesis adalah proses tumbuhan mengubah energi "
            "cahaya menjadi energi kimia."
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
        max_new_tokens=200,
        do_sample=False,
        pad_token_id=tokenizer.eos_token_id
    )

answer = outputs[0][inputs["input_ids"].shape[1]:]

print(tokenizer.decode(answer, skip_special_tokens=True))