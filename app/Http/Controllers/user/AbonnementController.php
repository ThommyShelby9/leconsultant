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
    public  $public_key= "2a9363b7c6c78cf76717f8895a561990f39bac73";
    public $private_key = "pk_e468b0c18dc058ebd9898cd7886efb85f3a8f3a628d0e3c41ba85feee1fae310";
    public $secret= "sk_d8ef36c0362a982cefbaa061a34e68ba9b828f3dbacc8987e45fc2833cd755e5";


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

    public function packSubscription($type, Request $req) {
        // Vérifiez si transaction_id est présent dans la requête
        if (!$req->has('transaction_id')) {
            return redirect()->route('welcome')->with('msg-error', 'ID de transaction manquant.');
        }
    
        // Configuration de Kkiapay
        $kkiapay = new \Kkiapay\Kkiapay(
            "2a9363b7c6c78cf76717f8895a561990f39bac73",
            "pk_e468b0c18dc058ebd9898cd7886efb85f3a8f3a628d0e3c41ba85feee1fae310",
            "sk_d8ef36c0362a982cefbaa061a34e68ba9b828f3dbacc8987e45fc2833cd755e5",
            false // Mode sandbox
        );
    
        // Vérification de la transaction
        $transactionVerification = $kkiapay->verifyTransaction($req->transaction_id);
    
        // Récupération des informations sur le pack
        $pack = DB::table('packs')->where('payant', 1)->where('id', $transactionVerification->state)->first(['nombre', 'titre']);
        if (!$pack) {
            return redirect()->route('welcome')->with('msg-error', 'Pack non trouvé.');
        }
        $pack_month = $pack->nombre;
        $pack_titre = $pack->titre;
    
        // Gestion des résultats de la transaction
        if ($transactionVerification->status == "SUCCESS") {
            // Récupérer l'abonnement existant de l'utilisateur
            $abon = Abonnement::where('idUser', Auth::user()->id)->orderByDesc('id')->first();
    
            // Si un abonnement existe, mettre à jour sa date de fin
            if ($abon) {
                if ($abon->typePack == 1) {
                    $abon->dateFin = date('Y-m-d'); // Mettre à jour la date de fin
                    $abon->save(); // Sauvegarder les changements
                }
            }
    
            // Créer un nouvel abonnement
            $newAbon = new Abonnement();
            $newAbon->idUser = Auth::user()->id;
            $newAbon->typePack = $transactionVerification->state;
            $newAbon->modeEssaie = 0;
            $newAbon->transaction_id = $req->transaction_id;
            $newAbon->dateDebut = date('Y-m-d');
            $newAbon->dateFin = date('Y-m-d', strtotime('+' . $pack_month . ' months'));
            $newAbon->save(); // Sauvegarder le nouvel abonnement
    
            // Mettre à jour la situation de l'utilisateur
            $user = User::find(Auth::user()->id);
            $user->situation = $pack_titre;
            $user->save();
    
            return redirect()->route('welcome')->with('msg-success', 'Abonnement activé avec succès.');
        } elseif ($transactionVerification->status == "TRANSACTION_NOT_FOUND") {
            return redirect()->route('welcome')->with('msg-error', 'Transaction introuvable.');
        }
    
        // Gestion d'autres états potentiels de la transaction
        return redirect()->route('mesAbonnements')->with('msg-error', 'Erreur lors de la vérification de la transaction.');
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
