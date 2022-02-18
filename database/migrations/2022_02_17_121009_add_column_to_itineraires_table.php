<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToItinerairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itineraires', function (Blueprint $table) {
            $table->foreignId('id_trajet')->unsigned()->references('id')->on('trajets');
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
            $table->dropConstrainedForeignId('id_trajet');
        });
    }
}
