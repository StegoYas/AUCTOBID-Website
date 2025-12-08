<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Note: Stored procedure is MySQL only. For SQLite, we skip this migration.
     * The winner calculation logic is handled in the Auction model.
     */
    public function up(): void
    {
        // Skip stored procedure for SQLite (not supported)
        if (DB::connection()->getDriverName() === 'sqlite') {
            // Create a placeholder comment - SQLite doesn't support stored procedures
            // Winner calculation will be done via PHP/Eloquent
            return;
        }

        // MySQL stored procedure for calculating auction winner
        DB::unprepared('
            DROP PROCEDURE IF EXISTS calculate_auction_winner;
            
            CREATE PROCEDURE calculate_auction_winner(IN auction_id_param BIGINT)
            BEGIN
                DECLARE winner_user_id BIGINT DEFAULT NULL;
                DECLARE winning_amount DECIMAL(15, 2) DEFAULT NULL;
                DECLARE commission_rate DECIMAL(5, 2) DEFAULT 5.00;
                DECLARE commission DECIMAL(15, 2) DEFAULT 0;
                
                -- Get commission rate from settings
                SELECT CAST(value AS DECIMAL(5,2)) INTO commission_rate 
                FROM settings 
                WHERE `key` = "commission_percentage" 
                LIMIT 1;
                
                -- Find the highest bid for this auction
                SELECT user_id, amount INTO winner_user_id, winning_amount
                FROM bids
                WHERE auction_id = auction_id_param
                ORDER BY amount DESC, created_at ASC
                LIMIT 1;
                
                -- If there is a winner
                IF winner_user_id IS NOT NULL THEN
                    -- Calculate commission
                    SET commission = winning_amount * (commission_rate / 100);
                    
                    -- Update all bids to not winning
                    UPDATE bids SET is_winning = 0 WHERE auction_id = auction_id_param;
                    
                    -- Mark the winning bid
                    UPDATE bids 
                    SET is_winning = 1 
                    WHERE auction_id = auction_id_param 
                    AND user_id = winner_user_id 
                    AND amount = winning_amount
                    LIMIT 1;
                    
                    -- Update auction with winner information
                    UPDATE auctions 
                    SET 
                        winner_id = winner_user_id,
                        final_price = winning_amount,
                        commission_amount = commission,
                        status = "ended",
                        closed_at = NOW()
                    WHERE id = auction_id_param;
                    
                    -- Update item status to sold
                    UPDATE items 
                    SET status = "sold"
                    WHERE id = (SELECT item_id FROM auctions WHERE id = auction_id_param);
                ELSE
                    -- No bids, mark as ended with no winner
                    UPDATE auctions 
                    SET 
                        status = "ended",
                        closed_at = NOW()
                    WHERE id = auction_id_param;
                    
                    -- Update item status to unsold
                    UPDATE items 
                    SET status = "unsold"
                    WHERE id = (SELECT item_id FROM auctions WHERE id = auction_id_param);
                END IF;
                
                -- Return the result
                SELECT winner_user_id as winner_id, winning_amount as final_price, commission as commission_amount;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::unprepared('DROP PROCEDURE IF EXISTS calculate_auction_winner');
        }
    }
};
