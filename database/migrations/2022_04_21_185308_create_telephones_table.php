<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelephonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telephones', function (Blueprint $table) {
            
            $table->increments('id');
            $table->integer('debertor_id')->unsigned();//Chave Estrangeira
            
            
            $table->foreign('debertor_id')
                    ->references('id')
                    ->on('debertors')
                    ->onDelete('cascade');
            
            $table->string('numero', 50);
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
        Schema::dropIfExists('telephones');
    }
}
