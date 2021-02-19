<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaClienteCpf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientePessoa', function (Blueprint $table) {
            $table->integer('id');
            $table->string('cpf')->unique();
            $table->string('rg');
            $table->timestamp('nascimento');
            $table->foreign('id')->references('id')->on('cliente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientePessoa');
    }
}
