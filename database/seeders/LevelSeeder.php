<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_level')->insert([
            [
                'level' => 'administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level' => 'petugas',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
