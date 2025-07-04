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
        Schema::create("articulos", function (Blueprint $table) {
            $table->id();
            $table->string("titulo");
            $table->longText("contenido");
            $table->unsignedBigInteger("autor_id");
            $table->longText('rutaImg');
            $table->timestamps();

            $table->foreign('autor_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("articulos");

    }
};
