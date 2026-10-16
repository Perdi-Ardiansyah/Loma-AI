<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create or update Demo User (Guest Account, clean initial state)
        User::updateOrCreate(
            ['email' => 'guest@loma.ai'],
            [
                'name' => 'Guest',
                'password' => Hash::make('password123'),
                'exp' => 100,
                'level' => 1,
                'streak' => 1,
                'role' => 'Guest',
            ]
        );

        // 2. Truncate any dummy learning tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('learning_flashcards')->truncate();
        DB::table('learning_quizzes')->truncate();
        DB::table('learning_sources')->truncate();
        DB::table('learning_modules')->truncate();
        DB::table('chat_histories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
