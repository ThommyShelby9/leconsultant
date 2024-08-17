<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Autorite;

class AutoriteController extends Controller
{
    function store(){

        $auto = DB::table('autorites')
                ->join('categories', 'categories.id', 'autorites.categ_id')
                ->get(['autorites.*', 'categories.title' , 'categories.abreviation as CatAbrev']);

        return view('adminView.autorite.store', ['autorites'=>$auto]);
    }
    function ajouter(){
        return view('adminView.autorite.add');
    }

    //Enregistrer
    function add(Request $req){



        if($req['photo'] == null){

            $req->validate([
                'categorie'=>['required',  'numeric'],
                'nom'=> ['required' , 'string' , 'max:60'],
                'abrev'=>['required' , 'string' , 'max:8'],
                'localisation'=> ['required' , 'string' , 'max:35'],
                'contact'=> ['required' , 'numeric'],
                'email'=> ['nullable', 'string' , 'email'],
            ]);

        }else{


            $req->validate([
                'categorie'=>['required',  'numeric'],
                'nom'=> ['required' , 'string' , 'max:60'],
                'abrev'=>['required' , 'string' , 'max:8'],
                'localisation'=> ['required' , 'string' , 'max:35'],
                'contact'=> ['required' , 'numeric'],
                'email'=> ['nullable', 'string' , 'email'],
                'photo'=>'required|file|mimes:jpg,png|max:5000000',
            ]);



        }

        //Voir le name n'existe pas

        /*if (Autorite::where('name', $req['nom'])->exists()) {

            return redirect()->route('admin.ac.list')
             ->with('msg-refuse', "La catégorie d'AC n'a pas été ajoutée. Une des données existe déjà");

        }else{

        }*/

        $au = new Autorite();
        $au->categ_id  = $req['categorie'];
        $au->name  = $req['nom'];
        $au->abreviation  = $req['abrev'];
        $au->localisation = $req['localisation'];
        $au->contact =$req['contact'];
        $au->email= $req['email'];
        $au->admin_id  = Auth::user()->id;

        if($req['photo'] != null){
            $chemin=$req->file('photo')->store('upload_files', 'public');
            $au->logo= $chemin;

        }

        $au->save();

        return redirect()->route('admin.ac.list')
        ->with('msg-success', "La catégorie d'AC a été bien ajoutée.");

    }

    //Modifier
    function edit($id){
        $auto = Autorite::find($id);

        return view('adminView.autorite.edit', ['autorite'=>$auto]);
    }

    //Sauvegarder les modif
    function edit_save(Request $req){

        $au = Autorite::find($req['id']);

        if($req['photo'] == null){

            $req->validate([
                'categorie'=>['required',  'numeric'],
                'nom'=> ['required' , 'string' , 'max:60'],
                'abrev'=>['required' , 'string' , 'max:8'],
                'localisation'=> ['required' , 'string' , 'max:35'],
                'contact'=> ['required' , 'numeric'],
                'email'=> ['nullable', 'string' , 'email'],
            ]);

        }else{


            $req->validate([
                'categorie'=>['required',  'numeric'],
                'nom'=> ['required' , 'string' , 'max:60'],
                'abrev'=>['required' , 'string' , 'max:8'],
                'localisation'=> ['required' , 'string' , 'max:35'],
                'contact'=> ['required' , 'numeric'],
                'email'=> ['nullable', 'string' , 'email'],
                'photo'=>'required|file|mimes:jpg,png|max:5000000',
            ]);

        }

        /* if (Autorite::where('name', $req['nom'])->exists()) {
            return redirect()->route('admin.ac.edit',$req['id'])
             ->with('msg-refuse', "La catégorie d'AC n'a pas été ajoutée. Une des données existe déjà");

        }else{

        }*/

        $au->categ_id  = $req['categorie'];
        $au->name  = $req['nom'];
        $au->abreviation  = $req['abrev'];
        $au->localisation = $req['localisation'];
        $au->contact =$req['contact'];
        $au->email= $req['email'];



        if($req['photo'] != null){

            $chemin=$req->file('photo')->store('upload_files', 'public');

            if(file_exists($au->logo)){
                unlink($au->logo);
            }
            $au->logo= $chemin;
        }




        $au->save();

        return redirect()->route('admin.ac.list')
        ->with('msg-success', "La catégorie d'AC a été bien ajoutée.");


    }

    function voir($idAutorite){


        $info = DB::table('autorites')
        ->join('categories', 'categories.id', 'autorites.categ_id')
        ->where('autorites.id',$idAutorite)
        ->get(['autorites.*', 'categories.title']);

        $directions = DB::table('directions')->where('aut_id', $idAutorite )->get();

        return view('adminView.autorite.see', ['info'=>$info , 'directions'=>$directions]);
    }
}
