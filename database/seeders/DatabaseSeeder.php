<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@auctobid.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Create Petugas
        User::create([
            'name' => 'Petugas Lelang',
            'email' => 'petugas@auctobid.com',
            'password' => Hash::make('password123'),
            'role' => 'petugas',
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Create sample Masyarakat
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567890',
            'address' => 'Jl. Contoh No. 123',
            'role' => 'masyarakat',
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Elektronik', 'description' => 'Perangkat elektronik dan gadget'],
            ['name' => 'Fashion', 'description' => 'Pakaian, aksesoris, dan perhiasan'],
            ['name' => 'Otomotif', 'description' => 'Kendaraan dan suku cadang'],
            ['name' => 'Properti', 'description' => 'Rumah, tanah, dan bangunan'],
            ['name' => 'Seni & Antik', 'description' => 'Karya seni dan barang antik'],
            ['name' => 'Olahraga', 'description' => 'Peralatan dan perlengkapan olahraga'],
            ['name' => 'Koleksi', 'description' => 'Barang koleksi dan memorabilia'],
            ['name' => 'Rumah Tangga', 'description' => 'Perabotan dan peralatan rumah'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Conditions
        $conditions = [
            ['name' => 'Baru', 'description' => 'Barang baru, belum pernah digunakan', 'quality_rating' => 10],
            ['name' => 'Seperti Baru', 'description' => 'Barang seperti baru, kondisi sempurna', 'quality_rating' => 9],
            ['name' => 'Sangat Baik', 'description' => 'Barang bekas dengan kondisi sangat baik', 'quality_rating' => 8],
            ['name' => 'Baik', 'description' => 'Barang bekas dengan kondisi baik', 'quality_rating' => 7],
            ['name' => 'Cukup Baik', 'description' => 'Barang bekas dengan kondisi cukup baik', 'quality_rating' => 6],
            ['name' => 'Bekas', 'description' => 'Barang bekas dengan tanda penggunaan wajar', 'quality_rating' => 5],
        ];

        foreach ($conditions as $condition) {
            Condition::create($condition);
        }

        // Initialize Settings
        Setting::initializeDefaults();
    }
}
