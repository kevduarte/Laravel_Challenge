<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->bigIncrements('borrower_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('borrower_status')->default("en curso");
            $table->unsignedBigInteger('manager_id');
            $table->foreign('manager_id')->references('manager_id')->on('manager');
             $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('member_id')->on('members');
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
        Schema::dropIfExists('borrowers');
    }
}
