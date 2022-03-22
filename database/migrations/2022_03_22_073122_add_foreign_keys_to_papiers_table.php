<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPapiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('papiers', function (Blueprint $table) {
            $table->foreign(['camion_id'], 'camion_id_foreign')->references(['id'])->on('camions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('papiers', function (Blueprint $table) {
            $table->dropForeign('camion_id_foreign');
        });
    }
}
