<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowersEjemplaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowers_ejemplares', function (Blueprint $table) {
            $table->text('detalle_prestamo');
            $table->unsignedBigInteger('id_ejemplar');
            $table->foreign('id_ejemplar')->references('id_ejemplar')->on('ejemplares');
            $table->unsignedBigInteger('borrower_id');
            $table->foreign('borrower_id')->references('borrower_id')->on('borrowers');
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
        Schema::dropIfExists('borrowers_ejemplares');
    }
}
