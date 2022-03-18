<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCarburantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carburants', function (Blueprint $table) {
            $table->foreign(['camion_id'], 'carburants_ibfk_1')->references(['id'])->on('camions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carburants', function (Blueprint $table) {
            $table->dropForeign('carburants_ibfk_1');
        });
    }
}
