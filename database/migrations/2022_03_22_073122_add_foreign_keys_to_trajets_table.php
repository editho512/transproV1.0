<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTrajetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trajets', function (Blueprint $table) {
            $table->foreign(['carburant_id'], 'carburant_id_foreign')->references(['id'])->on('carburants');
            $table->foreign(['chauffeur_id'], 'trajet_chauffeur_id_foreign')->references(['id'])->on('chauffeurs');
            $table->foreign(['camion_id'], 'trajet_camion_id_foreign')->references(['id'])->on('camions');
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
            $table->dropForeign('carburant_id_foreign');
            $table->dropForeign('trajet_chauffeur_id_foreign');
            $table->dropForeign('trajet_camion_id_foreign');
        });
    }
}
