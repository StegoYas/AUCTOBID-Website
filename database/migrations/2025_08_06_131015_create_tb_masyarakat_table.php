<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_masyarakat', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama_lengkap', 25);
            $table->string('username', 25);
            $table->string('password', 255);
            $table->string('email', 50)->unique();
            $table->string('telp', 25);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_masyarakat');
    }
};
