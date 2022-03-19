<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarburantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carburants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('quantite');
            $table->boolean('flux')->default(false);
            $table->timestamp('date')->nullable();
            $table->unsignedBigInteger('camion_id')->index('camion_id');
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
        Schema::dropIfExists('carburants');
    }
}
