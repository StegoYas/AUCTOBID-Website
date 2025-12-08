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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('opened_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->decimal('current_price', 15, 2);
            $table->integer('total_bids')->default(0);
            $table->enum('status', ['scheduled', 'active', 'ended', 'cancelled'])->default('scheduled');
            $table->foreignId('winner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('final_price', 15, 2)->nullable();
            $table->decimal('commission_amount', 15, 2)->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            $table->index(['status', 'end_time']);
            $table->index('winner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
