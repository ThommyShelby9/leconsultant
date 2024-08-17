<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Autorite;
use App\Models\Direction;

class DirectionController extends Controller
{
    function store(){


        $dire = DB::table('directions')
        ->join('autorites', 'directions.aut_id', 'autorites.id')
        ->join('categories', 'categories.id', 'autorites.categ_id')
        ->get(['directions.*', 'autorites.abreviation as abrev_aut' , 'autorites.name as name_aut', 'categories.title']);

        return view('adminView.direction.store', ['directions'=>$dire]);
    }
    function createDirection(){
        return view('adminView.direction.create');
    }
    function creerDirection($idAutorite){

        $info = DB::table('autorites')
             ->join('categories', 'categories.id', 'autorites.categ_id')
             ->where('autorites.id',$idAutorite)
             ->get(['autorites.*', 'categories.title']);

        $directions = DB::table('directions')->where('aut_id', $idAutorite )->get();

        return view('adminView.direction..page', ['info'=>$info , 'directions'=>$directions]);

    }

    function SaveDirection(Request $req){

        if($req['type_page'] == "direct"){

            $req->validate([
                'autorite'=>['required','numeric'],
                'nom'=> ['required' , 'string' , 'max:60'],
                'abrev'=>['required' , 'string' , 'max:8'],
            ]);


            $direc = new Direction();
            $direc->aut_id = $req['autorite'];
            $direc->name = $req['nom'];
            $direc->abreviation = $req['abrev'];
            $direc->save();

            return redirect()->route('admin.direction.list')
            ->with('msg-success', "La direction a été bien ajoutée.");

        }elseif($req['type_page'] == "nodirect"){

            $req->validate([
                'idAuto'=>['required','numeric'],
                'nom'=> ['required' , 'string' , 'max:60'],
                'abrev'=>['required' , 'string' , 'max:8'],
            ]);

            $direc = new Direction();
            $direc->aut_id = $req['idAuto'];
            $direc->name = $req['nom'];
            $direc->abreviation = $req['abrev'];
            $direc->save();

            return redirect()->route('admin.direction.new',$req['idAuto'])
            ->with('msg-success', "La direction a été bien ajoutée.");

        }


    }

    function modifierDirection($id){
        $direc= Direction::find($id);
        return view('adminView.direction.edit',['direction'=>$direc]);
    }

    function saveModif(Request $req){

        $req->validate([
            'autorite'=>['required','numeric'],
            'nom'=> ['required' , 'string' , 'max:60'],
            'abrev'=>['required' , 'string' , 'max:8'],
        ]);


        $direc = Direction::find($req['id']);
        $direc->aut_id = $req['autorite'];
        $direc->name = $req['nom'];
        $direc->abreviation = $req['abrev'];
        $direc->save();

        return redirect()->route('admin.direction.list')
        ->with('msg-success', "La direction a été bien modifiée.");
    }
}
