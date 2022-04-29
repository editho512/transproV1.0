<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItinerairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itineraires', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom', 255);
            $table->timestamps();
            $table->unsignedBigInteger('id_trajet')->index('itineraires_id_trajet_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itineraires');
    }
}
