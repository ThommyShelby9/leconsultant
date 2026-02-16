<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Abonnement;
use App\Models\User;
use App\Models\Pack;
use App\Services\PaymentService;
use RealRashid\SweetAlert\Facades\Alert;

class AbonnementController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    function mesAbonnementsPage(){
        return view('userView.abonnement');
    }

    function mesAbonnements(){

        $abon = DB::table('abonnements')
        ->join('packs', 'packs.id', 'abonnements.typePack')
        ->where('abonnements.idUser', Auth::user()->id)
        ->OrderBy('abonnements.id', 'desc')->limit(1)->get();

        $abonListe = DB::table('abonnements')
        ->join('packs', 'packs.id', 'abonnements.typePack')
        ->where('abonnements.idUser', Auth::user()->id)
        ->OrderBy('abonnements.id', 'desc')->get();

        return view('userView.account.mesA', ['actuel'=>$abon , 'lesAbonnements'=>$abonListe]);

    }

    /**
     * Activer l'essai gratuit de 14 jours
     */
    function essaieSubscription(Request $req){

        $ligne = DB::table('abonnements')->where('idUser',Auth::user()->id)
        ->where('modeEssaie',1)->count();

        if($ligne == 0){

            $ligne = DB::table('abonnements')
            ->where('idUser',Auth::user()->id)->orderByDesc('abonnements.id')->get(['id']);

            if (count($ligne) > 0) {
                $id = $ligne[0]->id;
                $abon = Abonnement::find($id);
                $abon->dateFin = date('Y-m-d');
                $abon->save();
            }

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

            Alert::success('Succès', 'Votre période d\'essai de 14 jours a été activée');
            return redirect()->route('mesAbonnements');

        }else{

            Alert::warning('Attention', 'Vous avez déjà épuisé vos 14 jours d\'essai');
            return redirect()->route('mesAbonnements');
        }
    }

    /**
     * Initier le paiement d'un abonnement avec PayPlus
     */
    public function initiateSubscription(Request $request, $packId)
    {
        try {
            // Valider les données
            $request->validate([
                'phone' => 'required|string|regex:/^[0-9]{8,15}$/',
            ]);

            // Récupérer le pack
            $pack = Pack::find($packId);

            if (!$pack) {
                Alert::error('Erreur', 'Pack introuvable');
                return redirect()->back();
            }

            // Montant du pack
            $amount = $pack->montant ?? config('payplus.packs.mensuel', 1490);

            // Initier le paiement via PayPlus
            $result = $this->paymentService->initiateSubscriptionPayment(
                Auth::user()->id,
                $amount,
                $request->input('phone'),
                $packId
            );

            if ($result['success']) {
                // Rediriger vers la page PayPlus
                return redirect()->away($result['redirect_url']);
            } else {
                Alert::error('Erreur', $result['message']);
                return redirect()->back();
            }

        } catch (\Exception $e) {
            Alert::error('Erreur', 'Une erreur est survenue lors de l\'initialisation du paiement');
            return redirect()->back();
        }
    }

    /**
     * Arrêter le mode essai
     */
    function EssaieStop(Request $req){

        $ligne = DB::table('abonnements')
        ->where('typePack',1)->where('modeEssaie', 1)
        ->where('idUser', Auth::user()->id)->limit(1)->get();

        if (count($ligne) > 0) {
            $abon = Abonnement::find($ligne[0]->id);
            $abon->dateFin = date('Y-m-d');
            $abon->stop = 1;
            $abon->save();
        }

        $abon = new Abonnement();
        $abon->idUser = Auth::user()->id;
        $abon->typePack = 1;
        $abon->dateDebut = date('Y-m-d');
        $abon->save();

        $user = User::find(Auth::user()->id);
        $user->situation = "Mode Gratuit";
        $user->save();

        Alert::success('Succès', 'Votre mode essai a été arrêté');
        return redirect()->route('mesAbonnements');

    }
}
