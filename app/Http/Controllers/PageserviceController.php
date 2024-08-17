<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Pageservice;

class PageserviceController extends Controller
{
    function store(){
        $serv = Pageservice::all();
        return view('adminView.site_web.services.list', ['services'=>$serv]) ;
    }

    function enregistrer(Request $req){

        if($req['fichier'] == null ){
            $req->validate([
                'titre'=>['required', 'string' , 'max:100'],
                'description'=>['required', 'string' , 'max:300'],
                'contenu'=>['required', 'string' ],
                'statut'=>['required', 'boolean'],
                //'fichier''fichier'=>'required|file|mimes:pdf|max:5000000',
            ]);
        }elseif( $req['fichier'] != null){
            $req->validate([
                'titre'=>['required', 'string' , 'max:100'],
                'description'=>['required', 'string' , 'max:300'],
                'contenu'=>['required', 'string' ],
                'statut'=>['required', 'boolean'],
                'fichier'=>'mimes:jpeg,jpg,png,webp|max:10000',
            ]);
        }


        $serv = new Pageservice();
        $serv->titre = $req['titre'];
        $serv->description =$req['description'];
        $serv->contenu = $req['contenu'];
        $serv->statut = $req['statut'];

        if($req['fichier'] != null){

            $chemin=$req->file('fichier')->store('site_upload', 'public');
            $serv->image = $chemin;
        }

        $serv->save();

        return redirect()->route('adminSite.services.list')->with('msg-success', 'Service bien enregistré');
    }

    function editer($id){
        $serv = Pageservice::find($id);
        return view('adminView.site_web.services.edit', ['service'=>$serv]) ;
    }


    function saveEdit(Request $req){

        if($req['fichier'] == null ){
            $req->validate([
                'id'=>['required', 'numeric'],
                'titre'=>['required', 'string' , 'max:100'],
                'description'=>['required', 'string' , 'max:300'],
                'contenu'=>['required', 'string' ],
                'statut'=>['required', 'boolean'],
                //'fichier''fichier'=>'required|file|mimes:pdf|max:5000000',
            ]);
        }elseif( $req['fichier'] != null){
            $req->validate([
                'id'=>['required', 'numeric'],
                'titre'=>['required', 'string' , 'max:100'],
                'description'=>['required', 'string' , 'max:300'],
                'contenu'=>['required', 'string' ],
                'statut'=>['required', 'boolean'],
                'fichier'=>'mimes:jpeg,jpg,png,webp|max:10000',
            ]);
        }


        $serv = Pageservice::find($req['id']);

        $serv->titre = $req['titre'];
        $serv->description =$req['description'];
        $serv->contenu = $req['contenu'];
        $serv->statut = $req['statut'];

        if($req['fichier'] != null){

            if(file_exists($serv->image)){
                unlink($serv->image);
            }

            $chemin=$req->file('fichier')->store('site_upload', 'public');
            $serv->image = $chemin;
        }

        $serv->save();

        return redirect()->route('adminSite.services.list')->with('msg-edit', 'Service bien modifié');
    }


    function cacher($id){

        $serv = Pageservice::find($id);
        $serv->statut = False;
        $serv->save();
        return redirect()->route('adminSite.services.list')->with('msg-edit', 'Service bien modifié');
    }

    function montrer($id){

        $serv = Pageservice::find($id);
        $serv->statut = True;
        $serv->save();
        return redirect()->route('adminSite.services.list')->with('msg-edit', 'Service bien modifié');
    }
}
