<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Learning Modules / Sessions
        Schema::create('learning_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title')->default('Modul: Transformasi Digital & Gamifikasi');
            $table->longText('summary')->nullable();
            $table->json('key_points')->nullable();
            $table->json('concept_map')->nullable();
            $table->timestamps();
        });

        // 2. Documents / Sources
        Schema::create('learning_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->nullable()->constrained('learning_modules')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('type')->default('pdf'); // pdf, docx, link, text
            $table->string('size_label')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Quizzes & Challenge Questions
        Schema::create('learning_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->nullable()->constrained('learning_modules')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title')->default('Kuis Tantangan (15 Pertanyaan)');
            $table->json('questions'); // 15 questions array
            $table->integer('last_score')->nullable();
            $table->integer('total_questions')->default(15);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // 4. Active Recall Flashcards
        Schema::create('learning_flashcards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->nullable()->constrained('learning_modules')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('front');
            $table->text('back');
            $table->boolean('is_mastered')->default(false);
            $table->integer('review_count')->default(0);
            $table->timestamps();
        });

        // 5. Chat History
        Schema::create('chat_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->nullable()->constrained('learning_modules')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('sender', ['user', 'ai']);
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_histories');
        Schema::dropIfExists('learning_flashcards');
        Schema::dropIfExists('learning_quizzes');
        Schema::dropIfExists('learning_sources');
        Schema::dropIfExists('learning_modules');
    }
}
