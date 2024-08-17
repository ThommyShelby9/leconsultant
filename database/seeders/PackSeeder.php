<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Dans PackSeeder.php
use App\Models\Pack;

class PackSeeder extends Seeder
{
    public function run()
    {
        Pack::create([
            'titre' => 'Gratuit',
            'payant' => false,
            'prix' => null,
            'nombre' => null,
            'modalite' => null
        ]);

        Pack::create([
            'titre' => 'Payant Un',
            'payant' => true,
            'prix' => 2000,
            'nombre' => 3,
            'modalite' => "Mois"
        ]);

        Pack::create([
            'titre' => 'Payant Deux',
            'payant' => true,
            'prix' => 4000,
            'nombre' => 3,
            'modalite' => "Mois"
        ]);

        Pack::create([
            'titre' => 'Payant 3',
            'payant' => true,
            'prix' => 7000,
            'nombre' => 6,
            'modalite' => "Mois"
        ]);
    }
}
