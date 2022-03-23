<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrajetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trajets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('chargement', 255);
            $table->string('bon', 255)->nullable();
            $table->string('bon_enlevement', 255)->nullable();
            $table->string('depart', 255);
            $table->string('arrivee', 255);
            $table->dateTime('date_heure_depart');
            $table->dateTime('date_heure_arrivee')->nullable();
            $table->string('etat')->nullable()->default('En  cours');
            $table->unsignedBigInteger('camion_id')->index('trajet_camion_id_foreign');
            $table->unsignedBigInteger('chauffeur_id')->nullable()->index('trajet_chauffeur_id_foreign');
            $table->double('carburant_depart')->nullable();
            $table->double('carburant_total')->nullable();
            $table->double('poids')->nullable();
            $table->unsignedBigInteger('carburant_id')->nullable()->index('carburant_id_foreign');
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
