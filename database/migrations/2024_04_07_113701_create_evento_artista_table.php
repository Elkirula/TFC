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
        Schema::create('evento_artista', function (Blueprint $table) {
            $table->unsignedBigInteger('evento_id');
            $table->unsignedBigInteger('artista_id');
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
            $table->foreign('artista_id')->references('id')->on('artistas')->onDelete('cascade');
            $table->string('video')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_artista');
    }
};
