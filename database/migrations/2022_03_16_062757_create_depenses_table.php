<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_heure')->nullable(false);
            $table->bigInteger('camion_id')->unsigned()->nullable();
            $table->bigInteger('chauffeur_id')->unsigned()->nullable();
            $table->string('type', 255)->nullable(false);
            $table->string('commentaire', 5000)->nullable();
            $table->timestamps();
            $table->foreign('camion_id')->references('id')->on('camions');
            $table->foreign('chauffeur_id')->references('id')->on('chauffeurs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depenses');
    }
}
