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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('category'); // Makanan, Transport, Hiburan, Gaji, dll
            $table->enum('type', ['income', 'expense'])->default('expense');
            $table->decimal('amount', 15, 2); // Max 999,999,999,999.99
            $table->date('date');
            $table->enum('status', ['paid', 'pending'])->default('paid');
            $table->timestamps();

            // Index untuk performa query
            $table->index(['user_id', 'type']);
            $table->index('date');
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
