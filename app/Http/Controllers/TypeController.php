<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Administrateur;
use App\Models\Type;

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


}
