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
            $table->string('user_name', 60)->comment('Name')->nullable();
            $table->string('user_joti', 100)->comment('Job title')->nullable();
            $table->bigInteger('user_phon')->comment('Phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
