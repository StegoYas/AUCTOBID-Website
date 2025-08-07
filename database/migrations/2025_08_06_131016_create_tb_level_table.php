<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_level', function (Blueprint $table) {
            $table->increments('id_level');
            $table->enum('level', ['administrator', 'petugas']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_level');
    }
};
