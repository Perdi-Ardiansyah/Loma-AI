<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

class AddGoogleFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('email')->index();
            $table->string('avatar', 500)->nullable()->after('role');
        });

        try {
            DB::statement("ALTER TABLE users MODIFY password VARCHAR(255) NULL");
        } catch (\Exception $e) {
            // Fallback: will generate random hash if null
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar']);
        });
    }
}
