<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

use App\Models\Formationticket;
use App\Models\User;

use Barryvdh\DomPDF\Facade\Pdf;



class FormationTicketController extends Controller
{
    function exemple(){
        $data = [
            'title' => 'Welcome to Tutsmake.com',
            'date' => date('m/d/Y')
        ];

        //$pdf = PDF::loadHTML('component.testPDF', $data);
        $pdf = PDF::loadHTML(View::make('component.ticketFormation',['infos'=>$data] ));

        return $pdf->stream();

        return "ok";
        //$data= DB::table('users')->get();

        //$pdf = Pdf::loadView('component.ticketFormation', ['infos'=>$data] );

        //return $pdf->download('invoice.pdf');

        $pdf = PDF::loadView('component.ticketFormation');

        return $pdf->download('demo.pdf');
        return $pdf->stream();

        return view('component.ticketFormation');
    }

    function mesFormations(){
        //Mes formations
        $mf = DB::table('formationtickets')
        ->join('formations', 'formationtickets.formation_id', 'formations.id')
        ->where('user_id', Auth::user()->id)
        ->orderBy('formationtickets.id', 'desc')
        ->get(['formationtickets.*', 'formations.titre', 'formations.imageForm', 'formations.prix', 'formations.firstDate']);

        //return view('bru.formation',['mesformations'=>$mf]);
        return "ok";

        return view('userView.account.mesFormations',['mesformations'=>$mf] );

        return view('userView.mesformations',['mesformations'=>$mf]);
    }


    function ticketFormation($idForm, Request $req){

        $kkiapay = new \Kkiapay\Kkiapay(
            "85abcb60ae8311ecb9755de712bc9e4f",
            "tpk_85abf271ae8311ecb9755de712bc9e4f",
            "tsk_85abf272ae8311ecb9755de712bc9e4f",
            $sandbox = true);

        $hgh = $kkiapay->verifyTransaction($req->transaction_id);

        if($hgh->status == "SUCCESS"){

            $ft = new Formationticket();
            $ft->user_id = Auth::user()->id ;
            $ft->formation_id = $idForm;
            $ft->idTransaction = $req->transaction_id ;
            $ft->dateTicket = date('Y-m-d') ;
            $ft->save() ;

            return redirect()->route('mesformations');

            //voir dans le naviagateur
            //return $pdf->stream();

        }elseif( $hgh->status== "TRANSACTION_NOT_FOUND"){

            return redirect()->route('mesformations')->with();
        }

    }

    function DownTicket(Request $req){
        $req->validate([
            'id'=>['required', 'numeric'],
            'trans'=>['required'],
        ]);

        $info = DB::table('formationtickets')
            ->join('users', 'users.id', 'formationtickets.user_id')
            ->join('formations', 'formations.id', 'formationtickets.formation_id')
            ->where('formationtickets.id', $req['id'] )
            ->where('formationtickets.idTransaction',$req['trans'])
            ->get(['formationtickets.idTransaction', 'formationtickets.dateTicket', 'nom', 'prenoms', 'email', 'typeActor', 'formations.titre', 'formations.confName', 'formations.lieu', 'formations.firstDate']);

        // L'instance PDF avec la vue resources/views/posts/show.blade.php
        $pdf = PDF::loadHTML(View::make('component.ticketFormation', ['infos'=>$info ] ));

        //Forcer le telechargement
        return $pdf->download("ticket-lecons-".$req['trans']."form828-drwt.pdf");
    }
}
