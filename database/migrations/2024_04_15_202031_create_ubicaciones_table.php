<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbicacionesTable extends Migration
{
    public function up()
    {
        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->double('latitud', 10, 6);
            $table->double('longitud', 10, 6);
            $table->timestamps();
        });

        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn('ubicacion');
            $table->unsignedBigInteger('ubicacion_id')->nullable()->after('eventos.user_id');
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign(['ubicacion_id']);
            $table->dropColumn('ubicacion_id');
            $table->string('ubicacion')->after('fecha_hora');
        });


        Schema::dropIfExists('ubicaciones');
 
    }
}
