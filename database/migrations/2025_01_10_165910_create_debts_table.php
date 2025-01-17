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
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->decimal('value_debit');
            $table->decimal('value_discount')->nullable();
            $table->string('parcel')->nullable();
            $table->enum('type_payment', ['DEBITO','CREDITO', 'DINHEIRO','PIX'])->default('DEBITO');
            $table->enum('status_debit', ['PENDING', 'PAID'])->nullable()->default('PENDING');
            $table->date('date_paid')->nullable();// data de pagamento
            $table->date('date_maturity')->nullable();//data de vencimento
            $table->string('observation')->nullable();
            $table->foreignId('banck_id')->nullable()->constrained('banks');
            $table->foreignId('provider_id')->nullable()->constrained('providers');
            $table->foreignId('card_id')->nullable()->constrained('cards');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
