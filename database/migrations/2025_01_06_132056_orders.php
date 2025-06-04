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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->decimal('costo',8,2);
        $table->string('estado')->default('pendiente'); 
        $table->timestamps();
        $table->string('stripe_payment_intent_id')->nullable();
        $table->string('metodo_pago')->default('stripe');
        $table->foreign('user_id')->references('id')->on('usuarios')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
