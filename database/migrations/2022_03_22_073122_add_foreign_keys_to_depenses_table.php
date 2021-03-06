<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('depenses', function (Blueprint $table) {
            $table->foreign(['camion_id'])->references(['id'])->on('camions');
            $table->foreign(['chauffeur_id'])->references(['id'])->on('chauffeurs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('depenses', function (Blueprint $table) {
            $table->dropForeign('depenses_camion_id_foreign');
            $table->dropForeign('depenses_chauffeur_id_foreign');
        });
    }
}
