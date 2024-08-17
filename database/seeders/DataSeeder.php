<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Administrateur;
use App\Models\Pageservice;
use App\Models\Type;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Administrateur::create([
            'name'=>'Admin Admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('12345678'),
            'role'=> 1,
            'isActif'=>1
        ]);

        Pageservice::create([
            'titre'=>'Conseils d’appel d’offres',
            'contenu'=> Str::random(10),
            'description'=> Str::random(10),
            'statut'=>1,
        ]);

        Pageservice::create([
            'titre'=>'Conseils d’appel d’offres',
            'contenu'=> Str::random(10),
            'description'=> Str::random(10),
            'statut'=>1,
        ]);
        Pageservice::create([
            'titre'=>'Conseils d’appel d’offres',
            'contenu'=> Str::random(10),
            'description'=> Str::random(10),
            'statut'=>1,
        ]);

        Type::create([
            'title'=>'Batiment et construction BTP',
            'useFor'=>'activite',
            'isDel'=>False
        ]);

        Type::create([
            'title'=>'Travaux publics',
            'useFor'=>'activite',
            'isDel'=>False
        ]);
        Type::create([
            'title'=>'Hottelerie et Restauration',
            'useFor'=>'activite',
            'isDel'=>False
        ]);

        Type::create([
            'title'=>'Fourniture',
            'useFor'=>'marche',
            'isDel'=>False
        ]);
        Type::create([
            'title'=>'Services',
            'useFor'=>'marche',
            'isDel'=>False
        ]);
        Type::create([
            'title'=>'Prestations intellectuelles',
            'useFor'=>'marche',
            'isDel'=>False
        ]);

    }
}
