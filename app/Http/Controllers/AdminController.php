<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Administrateur;

class AdminController extends Controller
{
    function dashBoard(){
        $client = DB::table('users')->count();
        $offre = DB::table('offres')->count();
        $formation = Db::table('formations')->count();
        $colab = DB::table('administrateurs')->count();

        $stat = DB::table('abonnements')
            ->select( array('packs.titre', DB::raw('COUNT(*) as nombre ')) )
            ->join('packs', 'abonnements.typePack', 'packs.id')
            ->groupBy('typePack')->get();

        $stat2 = DB::table('users')
            ->select( array('typeActor',DB::raw('COUNT(*) as nombre ')) )
            ->groupBy('typeActor')->get();

        //return json_encode($stat) ;

        return view('adminView.home',
        ['client'=>$client , 'offre'=>$offre , 'formation'=>$formation, 'colab'=>$colab , 'stat1'=>json_encode($stat), 'stat2'=>json_encode($stat2) ]);
    }

    function block($id){

        $admin = Administrateur::find($id);
        $admin->isActif = 0;
        $admin->save();

        return redirect()->route('admin.colab.list')
        ->with('msg-success', "Collaborateur banni du système.");
    }
    function unblock($id){

        $admin = Administrateur::find($id);
        $admin->isActif = 1;
        $admin->save();

        return redirect()->route('admin.colab.list')
        ->with('msg-success', "Collaborateur débloqué du système.");
    }

    function modifier($id){
        $admin = Administrateur::find($id);
        return view('adminView.colab.edit',['admin'=>$admin]);
    }

    function modifierSave(Request $req){

        $req->validate([
            'role'=>['required',  'numeric'],
            'pseudo'=> ['required' , 'string' , 'max:60'],
            'id'=>['required' , 'numeric', 'min:1' ],
        ]);

        $admin = Administrateur::find($req['id']);
        $admin->name = $req['pseudo'];
        $admin->role = $req['role'];
        $admin->save();

        return redirect()->route('admin.colab.list')
        ->with('msg-success', "Modification reussie.");
    }

    function store(){
        $admin = Administrateur::all();
        return view('adminView.colab.list',['admins'=>$admin]);
    }
    function creer(){
        return view('adminView.colab.create');
    }

    function saveColab(Request $req){

        $req->validate([
            'role'=>['required',  'numeric'],
            'pseudo'=> ['required' , 'string' , 'max:60'],
            'email'=>['required' , 'string' ],
            'mdp'=> ['required' , 'string' ],
            'mdp1'=> ['required' , 'string'],
        ]);

        if( $req['mdp'] == $req['mdp1']){

            $admin = new Administrateur();
            $admin->name = $req['pseudo'];
            $admin->email = $req['email'];
            $admin->password = Hash::make($req['mdp']);
            $admin->role = $req['role'];
            $admin->isActif = 1;
            $admin->save();
            //Envoyer un mail à la personne

            return redirect()->route('admin.colab.list')
                ->with('msg-success', "Le collaborateur a été bien ajouté.");

        }else{
            return back();
        }
    }
}
