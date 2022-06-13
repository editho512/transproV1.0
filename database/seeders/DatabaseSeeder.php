<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Piece;
use App\Models\Camion;
use App\Models\Fournisseur;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)->create();
        Camion::factory(5)->create();
        Piece::factory(10)->create();
        Fournisseur::factory(2)->create();
    }
}
