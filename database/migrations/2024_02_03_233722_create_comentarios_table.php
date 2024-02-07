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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('autor')->nullable();
            $table->string('cuerpo', 255);
            $table->unsignedBigInteger('respuestaA')->nullable();
            $table->timestamps();

            $table->foreign('autor')->references('id')->on('users')->onDelete('set null');
            $table->foreign('respuestaA')->references('id')->on('comentarios')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
