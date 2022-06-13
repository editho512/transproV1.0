<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemorquePapiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remorque_papiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('designation');
            $table->string('type');
            $table->dateTime('date');
            $table->dateTime('date_echeance');
            $table->unsignedBigInteger('remorque_id');
            $table->text('photo')->nullable();
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
        Schema::dropIfExists('remorque_papiers');
    }
}
