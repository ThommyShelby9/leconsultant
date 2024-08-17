<section class="container">
    <div class="grid lg:grid-cols-3 grid-cols-1 gap-10 mt-15 mb-10 ">
        @foreach ($les_packs as $item)
        <div class="relative bg-white rounded-3xl border border-consultant-blue">
            <div class="py-5 px-8">
                <div class="flex flex-col justify-between">
                    <div class="flex flex-col items-center">
                        <h3 class="pills-abonnement">
                           {{$item->titre}}
                        </h3>
                        <div class="mb-2">
                            <h4 class="lg:text-5xl text-xl text-consultant-rouge flex items-center">
                               {{$item->prix}} Fcfa
                            </h4>
                        </div>
                        <div class="mb-7">
                            <h4 class="lg:text-3xl text-xl text-consultant-rouge flex items-center">
                               <span class="lg:text-2xl text-lg text-consultant-blue ml-2">pour {{$item->nombre." ".$item->modalite}}</span>
                            </h4>
                        </div>
                        <ul class="list-abo">
                            <li class="lg:text-lg text-sm mb-3">
                                Faire des Recherches avancées
                            </li>
                            <li class="lg:text-lg text-sm mb-3">
                                Créer des alertes et Recevoir les offres par mail
                            </li>
                            <li class="lg:text-lg text-sm mb-3">
                                Possibilité de voir les détails et de télécharger les appels d'offres
                            </li>
                            <li class="lg:text-lg text-sm">
                                Possibilité de télecharger l'avis des appels d'offres
                            </li>
                        </ul>
                    </div>
                    <div class="text-center my-4">
                        <kkiapay-widget
                            amount="{{$item->prix}}"
                            key="85abcb60ae8311ecb9755de712bc9e4f"
                            url="<url-vers-votre-logo>"
                                position="center" sandbox="true"
                                data="{{$item->id}}"
                            callback="{{ route('pack.payant' , 10 ) }} ">
                        </kkiapay-widget>
                    </div>
                    <!--div class="flex mt-24 mb-12">
                        <a href="" class="py-4 px-16 border text-center border-consultant-rouge2 rounded-full w-full bg-white">
                            Get Started
                        </a>
                    </div-->

                </div>

            </div>
        </div>
        @endforeach
    </div>
</section>
