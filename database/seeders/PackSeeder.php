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
            'titre' => 'Unique',
            'payant' => true,
            'prix' => 50, // TEST
            'nombre' => 1,
            'modalite' => "Mois"
        ]);

    }
}
