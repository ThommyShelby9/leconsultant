<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Abonnement;
use App\Models\User;

class AbonnementController extends Controller
{
    public  $public_key= "85abcb60ae8311ecb9755de712bc9e4f";
    public $private_key = "tpk_85abf271ae8311ecb9755de712bc9e4f";
    public $secret= "tsk_85abf272ae8311ecb9755de712bc9e4f";


    function mesAbonnementsPage(){
        return view('userView.abonnement');
    }

    function mesAbonnements(){

        $abon = DB::table('abonnements')
        ->join('packs', 'packs.id', 'abonnements.typePack')
        ->where('abonnements.idUser', Auth::user()->id)
        ->OrderBy('abonnements.id', 'desc')->limit(1)->get();

        //return $abon;

        $abonListe = DB::table('abonnements')
        ->join('packs', 'packs.id', 'abonnements.typePack')
        ->where('abonnements.idUser', Auth::user()->id)
        ->OrderBy('abonnements.id', 'desc')->get();

        //return view('userView.account.mesA');

        return view('userView.account.mesA', ['actuel'=>$abon , 'lesAbonnements'=>$abonListe]);

    }

    function essaieSubscription(Request $req){

        $ligne = DB::table('abonnements')->where('idUser',Auth::user()->id)
        ->where('modeEssaie',1)->count();


        if($ligne == 0){

            $ligne = DB::table('abonnements')
            ->where('idUser',Auth::user()->id)->orderByDesc('abonnements.id')->get(['id']);

            $id = $ligne[0]->id;

            $abon = Abonnement::find($id);
            $abon->dateFin = date('Y-m-d');
            $abon->save();

            $abon =  new Abonnement();
            $abon->idUser = Auth::user()->id ;
            $abon->typePack = 1;
            $abon->modeEssaie = 1;
            $abon->dateDebut = date('Y-m-d') ;
            $abon->dateFin = date('Y-m-d' , strtotime('+14 days')) ;
            $abon->save();

            $user = User::find(Auth::user()->id);
            $user->situation = "Mode Essaie";
            $user->save();

            return redirect()->route('mesAbonnements')->with('msg-success','');

        }else{

            return redirect()->route('mesAbonnements')->with('msg-success',"Vous avez déja épuisé vos 14 jours d'essaie");
        }
    }

    function packSubscription($type, Request $req){



        $kkiapay = new \Kkiapay\Kkiapay(
            "85abcb60ae8311ecb9755de712bc9e4f",
            "tpk_85abf271ae8311ecb9755de712bc9e4f",
            "tsk_85abf272ae8311ecb9755de712bc9e4f",
            $sandbox = true);

        $hgh = $kkiapay->verifyTransaction($req->transaction_id);


         $pack = DB::table('packs')->where('payant',1)->where('id',$hgh->state)->get(['nombre' , 'titre']);
        $pack_month =  $pack[0]->nombre;
        $pack_titre =  $pack[0]->titre;


        if($hgh->status == "SUCCESS"){

            $ligne = DB::table('abonnements')
            ->where('idUser',Auth::user()->id)->orderByDesc('abonnements.id')->get(['id']);

            $id = $ligne[0]->id;
            $abon = Abonnement::find($id);

            if($abon->typePack == 1){
                $abon->dateFin = date('Y-m-d');
            }
            $abon->save();

            $abon =  new Abonnement();
            $abon->idUser = Auth::user()->id ;
            $abon->typePack = $hgh->state;
            $abon->modeEssaie = 0;
            $abon->transaction_id = $req->transaction_id;
            $abon->dateDebut = date('Y-m-d') ;
            $abon->dateFin = date('Y-m-d' , strtotime('+'.$pack_month.' months')) ;
            $abon->save();


            $user = User::find(Auth::user()->id);
            $user->situation =  $pack_titre;
            $user->save();

            return redirect()->route('mesAbonnements')->with('msg-success','');

        }elseif( $hgh->status== "TRANSACTION_NOT_FOUND"){

            return redirect()->route('mesAbonnements');
        }

    }

    function EssaieStop(Request $req){

        $ligne = DB::table('abonnements')
        ->where('typePack',1)->where('modeEssaie', 1)
        ->where('idUser', Auth::user()->id)->limit(1)->get();


        //$ligne[0]->id;

        $abon = Abonnement::find($ligne[0]->id);
        $abon->dateFin = date('Y-m-d');
        $abon->stop = 1;
        $abon->save();

        $abon = new Abonnement();
        $abon->idUser = Auth::user()->id;
        $abon->typePack = 1;
        $abon->dateDebut = date('Y-m-d');
        $abon->save();

        $user = User::find(Auth::user()->id);
        $user->situation = "Mode Gratuit";
        $user->save();

        return redirect()->route('mesAbonnements')->with('msg-success','');

    }

    public function handleCallback(Request $request)
    {
        // Valider la requête et les paramètres de Kkiapay
        $validatedData = $request->validate([
            'status' => 'required|string',
            'transaction_id' => 'required|string',
            'amount' => 'required|numeric',
            'reference' => 'required|string',
        ]);

        // Vérifier si la transaction est réussie
        if ($validatedData['status'] === 'SUCCESS') {
            // Trouver l'utilisateur connecté
            $user = Auth::user(); 

            // Créer ou mettre à jour l'abonnement
            $abonnement = Abonnement::updateOrCreate(
                ['idUser' => $user->id, 'typePack' => 'unique'],
                [
                    'dateDebut' => now(),
                    'dateFin' => now()->addMonth(3), // Abonnement d'un an
                    'transaction_id' => $validatedData['transaction_id'],
                    'stop' => false
                ]
            );

            // Optionnel : mettre à jour le statut de l'utilisateur
            // $user->update(['has_active_subscription' => true]);

            return response()->json(['message' => 'Abonnement activé avec succès'], 200);
        } else {
            return response()->json(['message' => 'Échec du paiement'], 400);
        }
    }

}
