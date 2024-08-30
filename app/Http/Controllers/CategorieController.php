<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Categorie;

class CategorieController extends Controller
{
    function store(){
        $categ = Categorie::all();
        return view('adminView.categorieAC.store', ['categories'=>$categ]);
    }

    //Enregistrer
    function add(Request $req){
        $req->validate([
            'title'=>['required',  'string' ],
            'abrev'=> ['required' , 'max:5'],
        ]);

        if (Categorie::where('title', $req['title'])->orWhere('abreviation',$req['abrev'])->exists()) {

            return redirect()->route('admin.categorie.list')
             ->with('msg-refuse', "La catégorie d'AC n'a pas été ajoutée. Une des données existe déjà");

        }else{

            $categ = new Categorie();
            $categ->title  = $req['title'];
            $categ->abreviation  = $req['abrev'];
            $categ->admin_id  = Auth::user()->id;
            $categ->save();

            return redirect()->route('admin.categorie.list')
            ->with('msg-success', "La catégorie d'AC a été bien ajoutée.");

        }

    }

    //Modifier
    function edit($id){
        $categ = Categorie::find($id);

        return view('adminView.categorieAC.edit', ['categorie'=>$categ]);
    }

    //Sauvegarder les modif
    function edit_save(Request $req){
       $categ =  Categorie::find($req['id']);

       $req->validate([
        'title'=>['required',  'string' , 'max:20'],
        'abrev'=> ['required' , 'max:5'],
        ]);

        //A revoir
        if (Categorie::where('id', '!=', $req['id'])->where('title', $req['title'])->orWhere('abreviation',$req['abrev'])->exists()) {

            return redirect()->route('admin.categorie.edit',$req['id'])
            ->with('msg-refuse', "La catégorie d'AC n'a pas été modifiée. Une des données existe déjà");

        }else{

            $categ->title  = $req['title'];
            $categ->abreviation  = $req['abrev'];
            $categ->admin_id  = Auth::user()->id;
            $categ->save();

            return redirect()->route('admin.categorie.list')
            ->with('msg-success', "La catégorie d'AC a été bien modifiée.");

        }
    }

}
