<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancePieceFrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_piece_frs', function (Blueprint $table) {
            $table->foreignId('piece')->references('id')->on('pieces');
            $table->foreignId('fournisseur')->references('id')->on('fournisseurs');
            $table->foreignId('maintenance')->references('id')->on('maintenances');

            $table->primary(['piece', 'fournisseur', 'maintenance'], 'pk_frs_piece_maintenance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_piece_frs');
    }
}
