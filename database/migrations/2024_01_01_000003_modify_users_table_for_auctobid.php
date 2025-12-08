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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'petugas', 'masyarakat'])->default('masyarakat')->after('email');
            $table->enum('status', ['pending', 'approved', 'suspended', 'rejected'])->default('pending')->after('role');
            $table->string('phone', 20)->nullable()->after('status');
            $table->text('address')->nullable()->after('phone');
            $table->string('identity_photo')->nullable()->after('address');
            $table->string('profile_photo')->nullable()->after('identity_photo');
            $table->timestamp('approved_at')->nullable()->after('profile_photo');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'role',
                'status',
                'phone',
                'address',
                'identity_photo',
                'profile_photo',
                'approved_at',
                'approved_by'
            ]);
        });
    }
};
