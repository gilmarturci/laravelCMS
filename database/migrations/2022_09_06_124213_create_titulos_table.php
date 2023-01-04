<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('titulos', function (Blueprint $table) {
            $table->increments('id');
             $table->integer('creditors_id')->unsigned(); //Chave Estrangeira;
            $table->foreign('creditors_id')
                    ->references('id')
                    ->on('creditors')
                    ->onDelete('cascade');
            $table->integer('debertor_id')->unsigned(); //Chave Estrangeira;
            $table->foreign('debertor_id')
                    ->references('id')
                    ->on('debertors')
                    ->onDelete('cascade');
            $table->string('nome', 50);
            $table->string('cpf/cnpj', 50);
            $table->string('email', 50);
            $table->string('vencimento', 50);
            $table->string('valor', 50);
            $table->string('contrato', 50);
            $table->string('parcela', 50);
            $table->string('tipo_titulo', 50);
            $table->string('tipo_negociacao', 50);
            $table->string('data_geracao', 50);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('titulos');
    }
}
