<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('intitule', 255)->nullable(false);
            $table->dateTime('date_heure')->nullable(false);
            $table->bigInteger('camion_id')->unsigned()->nullable();
            $table->string('type', 255)->nullable(false);
            $table->string('commentaire', 5000)->nullable();
            $table->string('nom_reparateur', 500)->nullable();
            $table->string('tel_reparateur', 255)->nullable();
            $table->string('adresse_reparateur', 255)->nullable();
            $table->double('main_oeuvre')->nullable();
            $table->json('pieces')->nullable();
            $table->timestamps();
            $table->foreign('camion_id')->references('id')->on('camions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenances');
    }
}
