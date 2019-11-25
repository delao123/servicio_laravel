<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellos', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->string('material');
            $table->string('tipo');
            $table->string('codigo_almacen');
            $table->string('cucop');
            $table->string('partida_presupuestal');
            $table->string('unidad_medida');
            $table->integer('cantidad');
            $table->integer('costo_unitario');
            $table->integer('subtotal');
            $table->integer('iva');
            $table->integer('costo_total');
            $table->string('comentarios');
            $table->string('centro_trabajo');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sellos');
    }
}
