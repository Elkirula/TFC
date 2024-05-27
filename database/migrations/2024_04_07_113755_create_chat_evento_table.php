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
        Schema::create('chat_evento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evento_id');
            $table->unsignedBigInteger('user_id');
  
            $table->text('contenido');
            $table->timestamps();
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_evento');
    }
};
