<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Autorite;
use App\Models\Direction;


class AjaxController extends Controller
{
    function afficher_autorite(Request $req){

        $autorite = DB::table('autorites')->where('categ_id', $req['idCateg'])
                    ->get(['id', 'name']);

        return $autorite;
    }
    function afficher_direction(Request $req){

        $direction = DB::table('directions')
            ->where('aut_id',$req['idAc'])
            ->get(['abreviation', 'name', 'id']);

        return $direction;
    }

}
