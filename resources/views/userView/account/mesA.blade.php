@extends('layout.userLayout.template-profil')

@section('titre')
<script src="https://cdn.kkiapay.me/k.js"></script>
<title>Le consultant | Appels d'Offres</title>
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
        @if($item->typePack != 1)
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

        <!-- Gratuit -->
        @if($item->typePack == 1)
            @if($item->modeEssaie == 0)
                <div class="row bg-white mb-5 p-5">
                    <div class="col-12 shadow-lg text-center py-5" style="border:2px solid #0140BA;">
                        <p style="color:  #575757 ; font-size: 17px;" class="mb-4">
                            Vous n'avez aucun Abonnement en cours. <br>
                            Vous etes en Mode Gratuit
                        </p>

                        <a href="#" class="btn my-3 lg:text-2xl text-lg" style="color: #0140BA; ">
                            Profitez de nos 14 jours d'essaie, pour tester les fonctionnalités que nous vous offrant en mode
                            PAYANT.

                        </a><br>

                        <form action="{{route('pack.essaie')}}" method="post">
                            @csrf
                            <button class="btn px-5 py-2 bg-consultant-rouge text-white lg:text-2xl text-lg " id="">
                                Benéficiez
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($item->modeEssaie == 1)
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
                        @if($item->dateFin > date('Y-m-d'))
                            <p style="color:  #575757 ; font-size: 17px;" class="mb-4">

                                @if(Session::get('msg-success'))
                                <span class="text-lg text-consultant-rouge">{{ Session::get('msg-success') }}</span>
                                @endif

                                Vous n'avez aucun Abonnement en cours. <br>
                                Vous etes en Mode Essaie. Vous profitez des 14 Jours que vous avons offert, {{$nbre}}.
                            </p>

                            <p>
                                Expire le {{ date("d M Y", strtotime( $item->dateFin) )  }}; Il vous reste <span
                                    class="bg-consultant-blue px-4 py-2 text-lg text-white">{{ 14 - $nbre2 }}</span> Jours
                            </p>

                            <p class="my-2">
                                <form action="{{ route('essaie.stop') }}" method="post" onsubmit="return confirm('Voulez-vous vraiment arreter le mode essaie ? Si oui, cette opération est irrevèssible') "  >
                                    @csrf
                                    <button  class="inline-block border border-consultant-blue text-consultant-rouge lg:px-4 lg:py-6 px-2 py-4 rounded-lg font-medium lg:text-2xl text-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Arreter mon essaie
                                    </button>
                                </form>
                            </p>
                        @else
                            <p style="color:  #575757 ; font-size: 17px;" class="mb-4">
                                Vous n'avez aucun Abonnement en cours. <br>
                                Vos 14 Jours d'esaie sont arrivés à termes. Souscrivez vous à notre pack payant
                            </p>
                        @endif
                    </div>
                </div>

                @include('component.alerte')

            @endif

            @include('component.packs')
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
                                @if($item->typePack == 1)
                                  @if($item->modeEssaie == 0)
                                  Mode Gratuit
                                  @else
                                  Mode Essaie
                                  @endif
                                @else
                                {{$item->titre}}
                                @endif
                            </td>
                            <td class="border border-consultant-rouge ...">{{ date('d M Y', strtotime($item->dateDebut)) }}</td>
                            <td class="border border-consultant-rouge ...">
                                @if($item->typePack != 1)
                                {{ date('d M Y', strtotime($item->dateFin)) }}
                                @else
                                @if($item->modeEssaie == 1)
                                {{ date('d M Y', strtotime($item->dateFin)) }}
                                @endif
                                @endif
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
<script src="https://cdn.kkiapay.me/k.js"></script>
@endsection
