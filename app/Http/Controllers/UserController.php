<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;


class UserController extends Controller
{


    public  $public_key= "85abcb60ae8311ecb9755de712bc9e4f";
    public $private_key = "tpk_85abf271ae8311ecb9755de712bc9e4f";
    public $secret= "tsk_85abf272ae8311ecb9755de712bc9e4f";


    function store(){

        $userPhys = DB::table('users')->where('typeActor',1)->get();
        $userMor = DB::table('users')->where('typeActor',2)->get();


        return view('adminView.clients.list',['userMor'=>$userMor , 'userPhys'=>$userPhys]);
    }

    function home2($idpack , Request $req){

        $kkiapay = new \Kkiapay\Kkiapay(
            "85abcb60ae8311ecb9755de712bc9e4f",
            "tpk_85abf271ae8311ecb9755de712bc9e4f",
            "tsk_85abf272ae8311ecb9755de712bc9e4f",
            $sandbox = true);

        $hgh = $kkiapay->verifyTransaction($req->transaction_id);

        if($hgh->status == "SUCCESS"){

            return "OUi bonne affaire";

        }elseif( $hgh->status== "TRANSACTION_NOT_FOUND"){

            return "Transaction Errornée";
        }
    }


}
