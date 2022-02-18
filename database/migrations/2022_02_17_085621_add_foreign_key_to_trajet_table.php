<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToTrajetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trajets', function (Blueprint $table) {
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
        Schema::table('trajets', function (Blueprint $table) {
            $table->dropForeign('camion_id');
            $table->dropForeign('chauffeur_id');
        });
    }
}
