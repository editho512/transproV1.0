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
            $table->bigIncrements('id');
            $table->string('designation');
            $table->string('type');
            $table->dateTime('date');
            $table->dateTime('date_echeance');
            $table->unsignedBigInteger('camion_id')->index('camion_id_foreign');
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
        Schema::dropIfExists('papiers');
    }
}
