<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Formation;


class FormationController extends Controller
{
    function store(){
        $form = DB::table('formations')
        ->get([ 'id', 'niveau', 'titre', 'dureeNbre', 'dureeMode', 'prix', 'firstDate', 'firstTime', 'dateExpiration']);

        return view('adminView.formation.liste', ['formations'=>$form]);
    }

    function publier(){
        return view('adminView.formation.create');
    }
    function enregistrer(Request $req){

        $req->validate([
            'niveau'=>['required', 'string'],
            'titre'=>['required', 'string'],
            'description'=>['required'],
            'competence'=>['nullable', 'max:255'],
            'dureeNbre'=>['required', 'numeric' , 'min:1' ,'max:24'],
            'dureeMode'=>['required', 'string'],
            'firstDate'=>['required'],
            'firstTime'=>['required'],
            'lieu'=>['required', 'string'],
            'prix'=>['required', 'numeric' , 'min:0'],
            'nbrePlace'=>['required', 'numeric'],
            'dateExpiration'=>['required'],
            'contenu'=>['required'],
            'confName'=>['required', 'string'],
            'confPoste'=>['nullable', 'string', 'max:100'],
            'source'=>['required', 'string'],

        ]);

        $img = array("formation-img/1.jpg", "formation-img/2.jpg", "formation-img/3.png", "formation-img/4.jpg");
        $rand_img = array_rand($img, 1);

        //$input[$rand_keys[0]]


        $form = new Formation;

        $form->niveau = $req['niveau'];
        $form->titre = $req['titre'];
        $form->description = $req['description'];
        $form->competence = $req['competence'];
        $form->dureeNbre = $req['dureeNbre'];
        $form->dureeMode = $req['dureeMode'];
        $form->firstDate = $req['firstDate'];
        $form->firstTime = $req['firstTime'];
        $form->lieu = $req['lieu'];
        $form->prix = $req['prix'];
        $form->nbrePlace = $req['nbrePlace'];
        $form->dateExpiration = $req['dateExpiration'];
        $form->contenu = $req['contenu'];
        $form->confName = $req['confName'];
        $form->confPost = $req['confPoste'];
        $form->source = $req['source'];
        $form->imageForm = $img[$rand_img];

        $form->save();

        return redirect()->route('admin.formation.list')->with('msg-success', 'La formation a été sauvegarder');

    }

    function editer($id){
        $form = Formation::find($id);
        return view('adminView.formation.edit' , ['formation'=>$form]);
    }
    function saveEdit(Request $req){
        $req->validate([
            'id'=>['required', 'numeric'],
            'niveau'=>['required', 'string'],
            'titre'=>['required', 'string'],
            'description'=>['required'],
            'competence'=>['nullable', 'max:255'],
            'dureeNbre'=>['required', 'numeric' , 'min:1' ,'max:24'],
            'dureeMode'=>['required', 'string'],
            'firstDate'=>['required'],
            'firstTime'=>['required'],
            'lieu'=>['required', 'string'],
            'prix'=>['required', 'numeric' , 'min:0'],
            'nbrePlace'=>['required', 'numeric'],
            'dateExpiration'=>['required'],
            'contenu'=>['required'],
            'confName'=>['required', 'string'],
            'confPoste'=>['nullable', 'string', 'max:100'],
            'source'=>['required', 'string'],

        ]);

        $form = Formation::find($req['id']);

        $form->niveau = $req['niveau'];
        $form->titre = $req['titre'];
        $form->description = $req['description'];
        $form->competence = $req['competence'];
        $form->dureeNbre = $req['dureeNbre'];
        $form->dureeMode = $req['dureeMode'];
        $form->firstDate = $req['firstDate'];
        $form->firstTime = $req['firstTime'];
        $form->lieu = $req['lieu'];
        $form->prix = $req['prix'];
        $form->nbrePlace = $req['nbrePlace'];
        $form->dateExpiration = $req['dateExpiration'];
        $form->contenu = $req['contenu'];
        $form->confName = $req['confName'];
        $form->confPost = $req['confPoste'];
        $form->source = $req['source'];
        $form->save();

        return redirect()->route('admin.formation.list')->with('msg-success', 'La formation a été modifiée');

    }

    function voir($id){
        $form = Formation::find($id);
        return view('adminView.formation.see' , ['formation'=>$form]);
    }

    function participant($id){

        $formInfo = Formation::find($id);

        $nbreP = DB::table('formationtickets')->where('formation_id', $id)->count();

        $form = DB::table('formations')
        ->get([ 'id', 'niveau', 'titre', 'dureeNbre', 'dureeMode', 'prix', 'firstDate', 'firstTime', 'dateExpiration']);

        $form= DB::table('formationtickets')
        ->join('formations', 'formationtickets.formation_id', 'formations.id')
        ->join('users', 'formationtickets.user_id', 'users.id')
        ->where('formationtickets.formation_id', $id)
        ->get(['formationtickets.*', 'users.*']);


        return view('adminView.formation.participant' , ['formation'=>$formInfo , 'nbreTicket'=>$nbreP, 'participants'=>$form]);
    }
}
