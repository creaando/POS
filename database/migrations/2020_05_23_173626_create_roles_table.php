<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',30)->unique();
            $table->string('descripcion',100)->nullable();
            $table->Boolean('condicion')->default (1);
        });
        DB::table('roles')->insert(array('id' => '1','nombre' => 'Administrador','descripcion' => 'Administradores del sistema'));
        DB::table('roles')->insert(array('id' => '2','nombre' => 'Vendedor','descripcion'      => 'Personal del área de ventas'));
        DB::table('roles')->insert(array('id' => '3','nombre' => 'Almacenista','descripcion'   => 'Encargado de bodega y almacén'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
