<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CatalogoHerramientas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_herramienta', function (Blueprint $table) {
            $table->string('clave')->unique();
            $table->string('material')->unique();
            $table->string('unidad_medida');
            $table->integer('precio_sin_iva');
            $table->integer('iva');
            $table->integer('precio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogo_herramienta');
    }
}
