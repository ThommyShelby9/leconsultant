@extends('bru.template')

@section('contenu')
<div class="row bg-white mb-5 p-5" id="info">
    <div class="col-12 shadow-lg  text-center py-5" style="border:2px solid #0140BA;">
        <p style="color:  #575757 ; font-size: 17px;">
            Vous avez un abonnnement de <b style="color:  #0140BA ;"> 3 Mois</b> en cours. <br>
            Expire le 24 Aout 2022, dans <b style="color:  #0140BA ;"> 15 Jours </b> exactement.
        </p>


        <button class="btn px-5 py-2 " id="bg-rouge">
            Stopper mon abonnement
        </button>

    </div>
</div>

<div class="row bg-white mb-5 p-5">
    <div class="col-12 shadow-lg text-center py-5" style="border:2px solid #0140BA;">
        <p style="color:  #575757 ; font-size: 17px;">
            Vous n'avez aucun Abonnement en cours. <br>
            Vous etes en Mode Gratuit
        </p>

        <a href="#" class="btn my-3" style="color: #0140BA; ">
            Profitez de nos 14 jours d'essaie, pour tester les fonctionnalités que nous vous offrant en mode PAYANT.

        </a>

        <button class="btn px-5 py-2 " id="bg-rouge">
            Benificiez
        </button>

    </div>
</div>

@endsection
