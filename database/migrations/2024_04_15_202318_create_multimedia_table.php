<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultimediaTable extends Migration
{
    public function up()
    {
        Schema::create('multimedia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evento_id');
            $table->string('tipo'); // Puede ser 'video', 'imagen', 'red_social', u otro tipo
            $table->string('archivo'); // URL del archivo o enlace a la red social
            $table->timestamps();

            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('multimedia');
    }
}
