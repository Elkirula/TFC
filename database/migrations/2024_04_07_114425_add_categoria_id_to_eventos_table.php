<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoriaIdToEventosTable extends Migration
{
    public function up()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropColumn('categoria_id');
        });
    }
}
