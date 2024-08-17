<?php

namespace Database\Seeders;

use App\Models\Autorite;
use App\Models\Categorie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categorie::create([
            'title'=>'Ministère',
            'abreviation'=> 'MRB',
            'admin_id'=>1,
        ]);
        Categorie::create([
            'title'=>'Entreprise Privée',
            'abreviation'=> 'EPB2',
            'admin_id'=>1,
        ]);
        Categorie::create([
            'title'=>'Entreprise Publique',
            'abreviation'=> 'EPB1',
            'admin_id'=>1,
        ]);
        Categorie::create([
            'title'=>'Centre de Santé',
            'abreviation'=> 'CST',
            'admin_id'=>1,
        ]);

        Autorite::create([
            'categ_id'=>1,
            'name'=> "Ministère de l'Agriculture, de l'elevage et de la peche",
            'abreviation'=>'MAEP',
            'localisation'=>'Cotonou',
            'contact'=>68686868,
            'admin_id'=>1
        ]);
        Autorite::create([
            'categ_id'=>1,
            'name'=> "Ministère du Sport et de la jeunesse",
            'abreviation'=>'MSJ',
            'localisation'=>'Cotonou',
            'contact'=>68686865,
            'admin_id'=>1
        ]);
        Autorite::create([
            'categ_id'=>2,
            'name'=> "Groupe Bolloré Afrique",
            'abreviation'=>'GBA',
            'localisation'=>'Cotonou',
            'contact'=>68786865,
            'admin_id'=>1
        ]);
        Autorite::create([
            'categ_id'=>2,
            'name'=> "OPEN SI BENIN",
            'abreviation'=>'OPEB',
            'localisation'=>'Cotonou',
            'contact'=>67786865,
            'admin_id'=>1
        ]);
        Autorite::create([
            'categ_id'=>4,
            'name'=> "Centre National Hospitalier Hubert Maga",
            'abreviation'=>'CNHU',
            'localisation'=>'Cotonou',
            'contact'=>68786867,
            'admin_id'=>1
        ]);
        Autorite::create([
            'categ_id'=>4,
            'name'=> "Hopital de Zone de Menontin",
            'abreviation'=>'CNHU',
            'localisation'=>'Cotonou',
            'contact'=>74786867,
            'admin_id'=>1
        ]);
    }
}
