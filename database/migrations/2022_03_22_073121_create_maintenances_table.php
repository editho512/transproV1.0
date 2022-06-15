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
            $table->bigIncrements('id');
            $table->string('titre', 255);
            $table->dateTime('date_heure');
            $table->unsignedBigInteger('camion_id')->nullable()->index('maintenances_camion_id_foreign');
            $table->string('type', 255);
            $table->string('commentaire', 5000)->nullable();
            $table->string('nom_reparateur', 500)->nullable();
            $table->string('tel_reparateur', 255)->nullable();
            $table->string('adresse_reparateur', 255)->nullable();
            $table->double('main_oeuvre')->nullable();
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
        Schema::dropIfExists('maintenances');
    }
}
