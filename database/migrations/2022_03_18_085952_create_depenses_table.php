<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date_heure');
            $table->unsignedBigInteger('camion_id')->nullable()->index('depenses_camion_id_foreign');
            $table->unsignedBigInteger('chauffeur_id')->nullable()->index('depenses_chauffeur_id_foreign');
            $table->string('type', 255);
            $table->decimal('montant', 12, 0);
            $table->string('commentaire', 5000)->nullable();
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
        Schema::dropIfExists('depenses');
    }
}
