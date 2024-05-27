<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventoIdToMultimediaTable extends Migration
{
    public function up()
    {
        // Verificar si la columna ya existe antes de agregarla
        if (!Schema::hasColumn('multimedia', 'evento_id')) {
            Schema::table('multimedia', function (Blueprint $table) {
                $table->unsignedBigInteger('evento_id');
                $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::table('multimedia', function (Blueprint $table) {
            $table->dropForeign(['evento_id']);
            $table->dropColumn('evento_id');
        });
    }
}