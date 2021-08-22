<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEjemplaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('ejemplares', function (Blueprint $table) {
             $table->bigIncrements('id_ejemplar');
             $table->string('codigo', 100);
             $table->integer('num_ejemplar');
             $table->string('estado_ejemplar')->default("Disponible");
             $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')->references('book_id')->on('books');
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
        Schema::dropIfExists('ejemplares');
    }
}
