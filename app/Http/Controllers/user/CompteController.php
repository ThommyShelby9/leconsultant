<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class CompteController extends Controller
{
    function account(){
        \Log::info('👤 User accessing account page', [
            'user_id' => Auth::user()->id,
            'payment_status' => request()->get('payment'),
            'url' => request()->fullUrl(),
            'referer' => request()->header('referer')
        ]);

        $user = user::find(Auth::user()->id);

        // Vérifier si l'utilisateur a un abonnement actif
        $activeSubscription = DB::table('abonnements')
            ->where('idUser', Auth::user()->id)
            ->where('dateFin', '>=', date('Y-m-d'))
            ->where('stop', 0)
            ->orderBy('id', 'desc')
            ->first();

        \Log::info('📋 User subscription status', [
            'user_id' => Auth::user()->id,
            'has_active_subscription' => $activeSubscription ? 'YES' : 'NO',
            'subscription_end' => $activeSubscription->dateFin ?? 'N/A'
        ]);

        // 🐛 DEBUG: Décommenter la ligne ci-dessous pour voir les détails
        // dd([
        //     'user' => $user,
        //     'active_subscription' => $activeSubscription,
        //     'payment_status' => request()->get('payment'),
        //     'all_subscriptions' => DB::table('abonnements')->where('idUser', Auth::user()->id)->get()
        // ]);

        //return $user;
        return view('userView.account.monCompte' , ['infos'=>$user] );
    }


    function mesSettings(){
        return view('userView.account.settingCompte' );
    }

    function editAccount(){
        $user = user::find(Auth::user()->id);
        return view('userView.account.monCompteEdit' , ['infos'=>$user] );
    }

    function saveEdit(Request $req){

        $req->validate([
            'idUser' => ['required', 'numeric'],
        ]);


        $user = user::find($req['idUser']);

        if($req['idUser']==Auth::user()->id){

            if($user->typeActor == 1){

                $req->validate([
                    'nom' => ['required', 'string', 'max:255'],
                    'prenoms' => ['required', 'string', 'max:255'],
                    'adresse' => ['required', 'string', 'max:255'],
                    'telephone' => ['required', 'numeric'],
                ]);

                $user->nom = $req['nom'];
                $user->prenoms= $req['prenoms'];
                $user->adresse = $req['adresse'];
                $user->telephone = $req['telephone'];

                $user->save();

            }elseif($user->typeActor == 2){


                $req->validate([
                    'societeType' => ['required'],
                    'nomSociete' => ['required', 'string', 'max:255'],
                    'adresse' => ['required', 'string', 'max:255'],
                    'telephone' => ['required', 'numeric'],
                ]);

                $user->typeSociete= $req['societeType'];
                $user->nomSociete= $req['nomSociete'];
                $user->adresseSociete = $req['adresse'];
                $user->telephoneSociete = $req['telephone'];

                $user->save();

            }

            return redirect()->route('moncompte')->with('msg-succes', 'Informations du compte bien modifés');

        }

    }
    function surMoi(){
        return view('userView.account.PlusOption' ,['action'=>'surMoi'] );
    }

    function surMoiSave(Request $req){
        $req->validate([
            'surmoi'=>['required', 'string', 'max: 500'],
        ]);

        $user = User::find(Auth::user()->id );
        $user->surmoi = $req['surmoi'];
        $user->save();

        return redirect()->route('moncompte');
    }

    function photo(){

        return view('userView.account.PlusOption' ,['action'=>'photo'] );
    }

    function savePhoto(Request $req){
        $req->validate([
            'maphoto'=>'required|file| mimes:jpeg,jpg,png|max:1000',
        ]);

        $chemin=$req->file('maphoto')->store('upload_files', 'public');

        $user = User::find(Auth::user()->id );
        $user->logo = $chemin;
        $user->save();

        return redirect()->route('moncompte');
    }

    function deletePhoto(){

        $user = User::find(Auth::user()->id );
        $user->logo = Null;
        $user->save();

        return redirect()->route('moncompte');
    }
}
