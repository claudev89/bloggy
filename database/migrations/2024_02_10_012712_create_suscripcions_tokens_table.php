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
        Schema::create('suscripcions_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token', 60);
            $table->unsignedBigInteger('suscripcion_id');
            $table->timestamps();

            $table->foreign('suscripcion_id')->references('id')->on('suscripcions')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suscripcions_tokens');
    }
};
