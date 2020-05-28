<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table ->foreignId('id')
                    ->references('id')
                    ->on('personas')
                    ->onDelete('cascade');
            // $table->integer('id')->unsigned();
            // $table->foreign('id')->references('id')->on('personas')->onDelete('cascade');

            $table->string('usuario')->unique();
            $table->string('password');
            $table->boolean('condicion')->default(1);

            $table ->foreignId('idrol')
                    ->references('id')
                    ->on('roles');
            // $table->integer('idrol')->unsigned();
            // $table->foreign('idrol')->references('id')->on('roles');

            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
