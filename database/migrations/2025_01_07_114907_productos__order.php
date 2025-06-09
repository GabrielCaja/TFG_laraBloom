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
        Schema::create('productos_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->decimal('precio_compra', 8, 2);

            // Relaciones
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_order');
    }
};
