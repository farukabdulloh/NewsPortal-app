<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('authors', function (Blueprint $table): void {
            $table->string('avatar')->nullable()->change();
            $table->longText('bio')->nullable()->change();
        });

        Schema::table('authors', function (Blueprint $table): void {
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table): void {
            $table->dropUnique(['user_id']);
        });

        // avatar/bio dibiarkan nullable agar rollback tidak gagal pada baris
        // yang sudah menyimpan NULL sejak fitur profil minimal dijalankan.
    }
};
