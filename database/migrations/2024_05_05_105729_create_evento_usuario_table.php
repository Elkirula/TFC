<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventoUsuarioTable extends Migration
{
    public function up()
    {
        Schema::create('evento_usuario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evento_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['evento_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('evento_usuario');
    }
}
