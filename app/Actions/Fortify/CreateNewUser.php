<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Abonnement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        if($input['typeActor']==1){


            Validator::make($input, [
                'nom' => ['required', 'string', 'max:255'],
                'prenoms' => ['required', 'string', 'max:255'],
                'adresse' => ['required', 'string', 'max:255'],
                //'telephone' => ['required', 'numeric' ],
                'telephone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10' , 'max:15'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ],
                'password' => $this->passwordRules(),
                'conditions'=>'required',
            ])->validate();



            User::create([
                'nom' => $input['nom'],
                'prenoms' => $input['prenoms'],
                'adresse' => $input['adresse'],
                'telephone' => $input['telephone'],
                'typeActor' => 1,
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'situation'=>"Mode Gratuit",
                'description'=> null,
            ]);

            //Creer l'Abonnement gratuit
            $user = DB::table('users')->where('email', $input['email'] )
            ->where('typeActor',1)->get(['id']);

            foreach($user as $item){
                $idU = $item->id;
            }

            $abon = new Abonnement();
            $abon->idUser = $idU;
            $abon->typePack = 1;
            $abon->dateDebut = date('Y-m-d');
            $abon->save();



            return $user = User::find($idU);


        }elseif($input['typeActor']==2){

            Validator::make($input, [
                'societeType' => ['required'],
                'nomSociete' => ['required', 'string', 'max:255'],
                'adresse' => ['required', 'string', 'max:255'],
                //'telephone' => ['required', 'numeric'],
                'telephone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10' , 'max:15'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ],
                'password' => $this->passwordRules(),
                'conditions'=>'required',
            ])->validate();

            User::create([
                'nomSociete' => $input['nomSociete'],
                'typeSociete' => $input['societeType'],
                'adresseSociete' => $input['adresse'],
                'telephoneSociete' => $input['telephone'],
                'typeActor' => 2,
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'situation'=>"Mode Gratuit",
                'description'=> 'Hello , nous sommes'+$input['nomSociete']+', Bienvenue sur mon profil.',
            ]);

            //Creer l'Abonnement gratuit
            $user = DB::table('users')->where('email', $input['email'] )
            ->where('typeActor',2)->get(['id']);

            foreach($user as $item){
                $idU = $item->id;
            }

            $abon = new Abonnement();
            $abon->idUser = $idU;
            $abon->typePack = 1;
            $abon->dateDebut = date('Y-m-d');
            $abon->save();


            return $user = User::find($idU);

        }
    }
}
