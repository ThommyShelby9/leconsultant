@extends('layout.userLayout.template-profil')

@section('titre')
<title>Le consultant | Mes Abonnements</title>
@endsection

@section('banner')

@endsection

@section('contenu')
<div class="tab-pane show active fade p-8 bg-white shadow" id="tabs-abonnementJustify" role="tabpanel"
    aria-labelledby="tabs-abonnement-tabJustify">
    <div class="w-2/3">
        <!--div class="flex flex-row">
            <div class="w-full">
                <h2 class="text-consultant-rouge lg:text-3xl text-2xl font-bold mb-8">
                    Mon abonnement actuel
                </h2>
            </div>
        </div-->

        @foreach ($actuel as $item)

        <!-- Payant 1 -->
        @if($item->typePack = 1)
            <div class="row bg-white mb-5 p-5">
                <div class="col-12 shadow-lg text-center py-5" style="border:2px solid #0140BA;">
                    <?php
                        $debut = new DateTime( $item->dateDebut );
                        $dateNow = new DateTime( date('Y-m-d'));

                        $interval = $dateNow->diff($debut);


                        $nbre2 =  $interval->format('%R%d');
                        if($nbre2 < 0){
                            $nbre2 =  - $nbre2 ;
                        }

                        $nbre=  $interval->format("Il s'est ecroulé ".$nbre2." jours déja" );
                    ?>

                    <p style="color:  #575757 ; font-size: 17px;" class="mb-4">
                        Vous avez un Abonnement de {{$item->nombre}} Mois en cours. <br>
                    </p>

                    <p>
                        Date d'abonnement <span
                        class="bg-consultant-blue px-4 py-2 text-lg text-white mr-4">{{ date("d M Y", strtotime($item->dateDebut) )  }}</span>
                        Expire le <span
                            class="bg-consultant-blue px-4 py-2 text-lg text-white">{{ date("d M Y", strtotime($item->dateFin) )  }}</span>
                    </p>
                </div>
            </div>

            @include('component.alerte')

        @endif

        @endforeach

        <div class="flex flex-row">
            <div class="w-full">
                <h2 class="text-consultant-rouge lg:text-3xl text-2xl font-bold mb-8">
                    Historique de mes abonnements
                </h2>
            </div>
        </div>
        <div class="flex flex-row">
            <div class="w-full ">
                <table class="w-full border-collapse border border-consultant-rouge w-[100%] ...">
                    <thead>
                        <tr>
                            <th class="border border-consultant-rouge ...">Type d'abonnement</th>
                            <th class="border border-consultant-rouge ...">Date de souscriptiopn</th>
                            <th class="border border-consultant-rouge ...">Date de fin</th>
                            <!--th class="border border-consultant-rouge ...">Statut</th-->
                        </tr>
                    </thead>
                    <tbody class="text-center" >
                        @foreach ($lesAbonnements as $item)
                        <tr>
                            <td class="border border-consultant-rouge ...">
                               
                                {{$item->titre}}
                            </td>
                            <td class="border border-consultant-rouge ...">{{ date('d M Y', strtotime($item->dateDebut)) }}</td>
                            <td class="border border-consultant-rouge ...">
                                {{ date('d M Y', strtotime($item->dateFin)) }}

                            </td>
                            <!--td class="border border-consultant-rouge ...">
                                En cours
                            </td-->
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection

@section('code')
{{-- PayPlus - Pas de script nécessaire ici --}}
@endsection
