<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papiers', function (Blueprint $table) {
            $table->id();
            $table->string("designation");
            $table->string("type");
            $table->dateTime("date");
            $table->dateTime("date_echeance");
            $table->bigInteger("camion_id");
            $table->text("photo");
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
        Schema::dropIfExists('papiers');
    }
}
