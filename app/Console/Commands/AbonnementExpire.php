<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Models\Abonnement;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Mail\AbonnementExpireMail;


class AbonnementExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abonnement:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Modifier la date des abonnements';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Modifier toutes les abonnements dont la date est aujourd'hui

        //La liste de ces users
        $users = DB::table('abonnements')
        ->join('users', 'abonnements.idUser', 'users.id')
        ->where('dateFin', '=' ,date('Y-m-d'))
        ->get([ 'abonnements.dateFin','abonnements.idUser', 'users.email',
            'users.nomSociete', 'users.nom', 'users.prenoms' ]);


        foreach($users as $item){

            //Rendre maintenant gratuit
            $abon = new Abonnement();

            $abon->idUser = $item->idUser;
            $abon->typePack = 1;
            $abon->dateDebut = date('Y-m-d');
            $abon->save();

            //Un mail Pour lui dire que c'est deja expiré
            $details = [
                'nom' => $item->nom. " ".$item->prenoms." ".$item->nomSociete ,
                'body' => ' ',
            ];

            Mail::to( $item->email )->send( new \App\Mail\AbonnementExpireMail ( $details ));
        }


        //return 0;
    }
}
