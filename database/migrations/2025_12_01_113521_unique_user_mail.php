<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'pgsql_store_cmd';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('store.user', function (Blueprint $table) {
            $table->string('user_mail', 100)->unique()->change();
        });

        DB::statement('UPDATE store.user SET user_mail = lower(user_mail)');
        DB::statement('UPDATE store.user_email_verify SET uemv_mail = lower(uemv_mail)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
