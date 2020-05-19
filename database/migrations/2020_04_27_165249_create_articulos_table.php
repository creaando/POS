<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table  ->foreignId('categoria_id')
                    ->references('id')
                    ->on('categorias');
            $table->string('codigo','50')->nullable();
            $table->string('nombre','100')->unique();
            $table->foreignId('unidadmedida_id')->constrained();
            $table->decimal('precio_compra','11','2')->nullable();
            $table->decimal('precio_venta','11','2');
            $table->integer('stock');
            $table->integer('stock_minimo');
            // $table->foreignId('persona_id')->constrained();
            // $table  ->foreignId('persona_id')
            //         ->references('id')
            //         ->on('personas');
            $table->string('descripcion','250')->nullable();
            $table->Boolean('condicion')->default (1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}
