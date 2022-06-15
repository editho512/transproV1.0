<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCamionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('plaque');            
            $table->string('annee')->nullable();
            $table->string('model')->nullable();
            $table->string('marque')->nullable();
            $table->string('numero_chassis')->nullable();
            $table->string('gps')->nullable();
            $table->text('gps_content')->nullable();
            $table->text('photo')->nullable();
            $table->boolean('blocked')->default(false);
            $table->timestamps();
            $table->boolean('disponible')->default(true);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('camions');
    }
}
