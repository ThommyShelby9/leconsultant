<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Administrateur;
use App\Models\Type;
use Illuminate\Support\Facades\Log;

class TypeController extends Controller
{
    function store(){
        $type = Type::all();
        return view('adminView.type.list',['types'=>$type]);
    }
    function creer(){
        return view('adminView.type.create');
    }

    function saveType(Request $req){
        $req->validate([
            'useFor'=>['required'],
            'titre'=>['required' , 'string' , 'max:40'],
        ]);
        $type = new Type();
        $type->useFor = $req['useFor'];
        $type->title = $req['titre'];
        $type->save();

        return redirect()->route('admin.type.list')
                ->with('msg-success', "Donnée bien crée.");
    }

    function editer($id){
        return view('adminView.type.edit', ['type'=> Type::find($id) ]);
    }
    function saveEdit(Request $req){

        $req->validate([
            'id'=>['required', 'numeric'],
            'useFor'=>['required'],
            'titre'=>['required' , 'string' , 'max:40'],
        ]);

        $type = Type::find($req['id']);
        $type->useFor = $req['useFor'];
        $type->title = $req['titre'];
        $type->save();

        return redirect()->route('admin.type.list')
                ->with('msg-success', "Donnée bien modfiée.");
    }


    public function delete($id)
{
    try {
        // Trouver l'offre par son ID
        $offre = Type::findOrFail($id);

        // Supprimer l'offre
        $offre->delete();

        // Rediriger avec un message de succès
        return redirect()->route('admin.type.list')->with('msg-success', 'L\'élément a été supprimé avec succès.');
    } catch (\Exception $e) {
        // Affichez l'erreur dans les logs pour le suivi
        Log::error('Erreur lors de la suppression de l\'offre : '.$e->getMessage());

        // Rediriger avec un message d'erreur
        return redirect()->route('admin.type.list')->with('msg-error', 'Erreur lors de la suppression de l\'offre.');
    }
}


}
