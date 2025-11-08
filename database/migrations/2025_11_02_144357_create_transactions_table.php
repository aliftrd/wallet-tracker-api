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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('wallet_id')->constrained('wallets')->cascadeOnDelete();
            $table->foreignId('user_category_id')->nullable()->constrained('user_categories')->cascadeOnDelete();
            $table->string('type', 10);
            $table->string('store_name', 50);
            $table->dateTimeTz('date');
            $table->string('note', 255)->nullable();
            $table->unsignedBigInteger('tax_amount');
            $table->unsignedBigInteger('total_amount');
            $table->timestamps();

            $table->index('user_id', 'idx_transactions_user_id');
            $table->index('wallet_id', 'idx_transactions_wallet_id');
            $table->index('user_category_id', 'idx_transactions_user_category_id');
            $table->index('id', 'idx_transactions_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
