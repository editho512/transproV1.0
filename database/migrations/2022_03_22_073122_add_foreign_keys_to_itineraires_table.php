<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToItinerairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itineraires', function (Blueprint $table) {
            $table->foreign(['id_trajet'])->references(['id'])->on('trajets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itineraires', function (Blueprint $table) {
            $table->dropForeign('itineraires_id_trajet_foreign');
        });
    }
}
