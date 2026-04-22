<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['user', 'admin', 'management'])->default('user'); // 👈 Tambahkan ini
            $table->string('no_telepon', 15)->nullable(); // 👈 Tambahkan ini
            $table->rememberToken();
            $table->timestamps();
        });

        // ... tabel lainnya
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};