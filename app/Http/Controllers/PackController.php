<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Pack;

class PackController extends Controller
{
    //Les abonnements
    function storePack(){
        $pack = DB::table('packs')->where('payant', True)->get();
        return view('adminView.abonnement.list',['pack'=>$pack]);
    }
    function newPack(){
        return view('adminView.abonnement.create');
    }
    function EditPack($id){
        $pack = Pack::find($id);
        return view('adminView.abonnement.edit',['pack'=>$pack]);
    }

    function SaveEdit(Request $req){
        //titre":"Silver","payant":"1","prix":"2500","modalite":"Mois",
        //"essaie":"0","periodeEssaie":null,"modaliteEssaie":"Jours"

        $req->validate([
            'id'=>['required'],
            'titre'=>['required', 'string' , 'max:10'],
            'prix'=>['required', 'numeric' , 'min:1000'],
            'modalite'=>['required'],
        ]);

        $pack = Pack::find($req['id']);
        $pack->titre = $req['titre'];
        $pack->prix = $req['prix'];
        $pack->save();

        return redirect()->route('admin.pack.list')->with('msg-success', 'Modification effectuée avec sucess');

    }



}
