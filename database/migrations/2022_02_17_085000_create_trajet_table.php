<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrajetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trajets', function (Blueprint $table) {
            $table->id();
            $table->string('depart', 255);
            $table->string('arrivee', 255);
            $table->dateTime('date_heure_depart');
            $table->dateTime('date_heure_arrivee')->nullable();
            $table->string('etat')->nullable('false')->default('En  cours');
            $table->bigInteger('camion_id')->unsigned();
            $table->bigInteger('chauffeur_id')->unsigned()->nullable();
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
        Schema::dropIfExists('trajets');
    }
}
