
import torch
from datasets import load_dataset
from transformers import (
    AutoTokenizer,
    AutoModelForCausalLM,
    Trainer,
    TrainingArguments,
    DataCollatorForLanguageModeling
)
from peft import LoraConfig, get_peft_model

MODEL_NAME = "Qwen/Qwen2.5-0.5B-Instruct"

# Batasi jumlah thread CPU
torch.set_num_threads(4)

# 1. Memuat tokenizer
tokenizer = AutoTokenizer.from_pretrained(MODEL_NAME)

if tokenizer.pad_token is None:
    tokenizer.pad_token = tokenizer.eos_token

# 2. Memuat dataset
dataset = load_dataset(
    "json",
    data_files="dataset/soal.jsonl",
    split="train"
)

# 3. Mengubah data menjadi format percakapan
def preprocess(example):
    messages = [
        {
            "role": "system",
            "content": (
                "Kamu adalah asisten pendidikan. "
                "Buat soal berdasarkan materi yang diberikan."
            )
        },
        {
            "role": "user",
            "content": (
                example["instruction"]
                + "\n\nMateri:\n"
                + example["input"]
            )
        },
        {
            "role": "assistant",
            "content": example["output"]
        }
    ]

    text = tokenizer.apply_chat_template(
        messages,
        tokenize=False
    )

    result = tokenizer(
        text,
        truncation=True,
        max_length=512,
        padding="max_length"
    )

    return result

tokenized = dataset.map(
    preprocess,
    remove_columns=dataset.column_names
)

# 4. Memuat model di CPU
model = AutoModelForCausalLM.from_pretrained(
    MODEL_NAME,
    torch_dtype=torch.float32
)

model.config.use_cache = False

# 5. Konfigurasi LoRA
lora_config = LoraConfig(
    r=4,
    lora_alpha=8,
    lora_dropout=0.05,
    bias="none",
    task_type="CAUSAL_LM",
    target_modules=[
        "q_proj",
        "k_proj",
        "v_proj",
        "o_proj"
    ]
)

model = get_peft_model(model, lora_config)
model.print_trainable_parameters()

# 6. Konfigurasi pelatihan CPU
training_args = TrainingArguments(
    output_dir="./edugen_results",
    num_train_epochs=1,
    per_device_train_batch_size=1,
    gradient_accumulation_steps=1,
    learning_rate=1e-4,
    logging_steps=1,
    save_strategy="epoch",
    report_to="none",
    use_cpu=True,
    dataloader_num_workers=0,
    optim="adamw_torch"
)

# 7. Menyiapkan data
collator = DataCollatorForLanguageModeling(
    tokenizer=tokenizer,
    mlm=False
)

trainer = Trainer(
    model=model,
    args=training_args,
    train_dataset=tokenized,
    data_collator=collator
)

# 8. Mulai pelatihan
trainer.train()

# 9. Simpan adapter LoRA
trainer.save_model("./edugen_model")
tokenizer.save_pretrained("./edugen_model")

print("Fine-tuning selesai!")