<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    @yield('titre')

    @include('includes.userLink.cssLink')

</head>

<body>
    <header class="relative">
        <nav id="main-menu" class="lg:flex lg:flex-wrap justify-between unsticky py-2 lg:px-12 px-4">

            @include('layout.userLayout.menu')

        </nav>
        @yield('banner')

        <section id="banner" class="relative overflow-hidden">
            <div class="bg-consultant-blue lg:flex lg:h-[540px] items-center block lg:pt-0 pt-8 lg:pb-0 pb-8">
                <div class="container">
                    <div class="bg-white px-11 pt-10 pb-12 lg:mb-6 mb-0" id="profile-header">
                        <div class="">
                            <div class="flex justify-end">
                                <a href="{{ route('moncompte.edit') }}" class="link-consultant lg:text-xl text-base">
                                    Modifier le profil
                                </a>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center">
                            <div class="lg:w-1/4 w-full">
                                @if( ! is_null(Auth::user()->logo) )
                                <img src="{{asset(Auth::user()->logo)}}" alt="" class="object-cover object-center w-full h-full rounded-full border-2 p-1">
                                <div class="flex justify-center">
                                    <a href="{{ route('moncompte.photo.delete') }}" class="text-consultant-rouge lg:text-xl text-base">
                                        Supprimer <i class="fa-solid fa-circle-minus"></i>
                                    </a>
                                </div>

                                @else
                                <img src="{{asset('profil_default.jpg')}}" alt="" class="object-cover object-center w-full h-full rounded-full border-2 p-1">

                                @endif

                                <div class="flex justify-center">
                                    <a href="{{ route('moncompte.photo') }}" class="text-consultant-rouge lg:text-xl text-base">
                                        Modifier <i class="ml-2 fa-solid fa-camera"></i>
                                    </a>
                                </div>

                            </div>
                            <div class="lg:w-3/4 w-full lg:px-10 px-0 mt-5">
                                <h1 class="lg:text-[50px] text-[30px] font-medium mb-4">
                                    {{ Auth::user()->nomSociete }}
                                </h1>
                                <h1 class="lg:text-[50px] text-[30px] font-medium mb-4">
                                    {{ Auth::user()->nom." ".Auth::user()->prenoms }}
                                </h1>
                                <hr class="w-full mb-4">
                                <div class="flex justify-end">
                                    <a href="{{ route('moncompte.surmoi') }}" class="text-consultant-rouge lg:text-xl text-base">
                                        Modifier ma description<i class="ml-2 fa-solid fa-camera"></i>
                                    </a>
                                </div>
                                <p class="lg:text-lg text-sm">
                                     {{Auth::user()->surmoi }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div class="lg:absolute relative left-0 right-0 -bottom-[3.5rem] z-10">
            <div class="container">
                <div class="bg-white">
                    <ul class="nav nav-tabs nav-justified shadow flex flex-col lg:flex-row flex-wrap list-none border-b-0 pl-0 mb-4" id="tabs-tabJustify" role="tablist">
                        <li class="nav-item flex-grow text-center" role="presentation">
                            <a href="{{ route('moncompte')}}"
                            class="nav-tab-c{{ request()->routeIs('moncompte')  ? ' active' : ''  }} {{ request()->routeIs('moncompte.edit')  ? ' active' : ''  }} "
                             aria-selected="true">
                                <i class="mr-2"><img src="assets/img/female.png" alt=""></i>
                                Mon Profil
                            </a>
                        </li>
                        <li class="nav-item flex-grow text-center" role="presentation">
                            <a href="{{ route('mesSetting')}}"
                            class="nav-tab-c{{ request()->routeIs('mesSetting')  ? ' active' : ''  }}" id="tabs-parametre-tabJustify"  aria-selected="false">
                                <i class="mr-2"><img src="assets/img/sett.png" alt=""></i>
                                Paramètre
                            </a>
                        </li>
                        <li class="nav-item flex-grow text-center" role="presentation">
                            <a href="{{ route('mesAbonnements')}}"
                            class="nav-tab-c{{ request()->routeIs('mesAbonnements')  ? ' active' : ''  }}" aria-selected="false">
                                <i class="mr-2"><img src="assets/img/ticket.png" alt=""></i>
                                Abonnement
                            </a>
                        </li>
                        <li class="nav-item flex-grow text-center" role="presentation">
                            <a href="{{ route('mesformations') }}"
                            class="nav-tab-c{{ request()->routeIs('mesformations')  ? ' active' : ''  }}" aria-selected="false">
                                <i class="mr-2"><img src="assets/img/grad.png" alt=""></i>
                                Formations
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </header>

    <main class="relative bg-consultant-gris2 pt-16 pb-8">
        <div class="container">
            <div class="bg-white">
                <div class="tab-content" id="tabs-tabContentJustify">

                    @yield('contenu')

                </div>
            </div>

        </div>
    </main>


    <footer class="relative bg-consultant-blue lg:pt-12 pt-4 lg:pb-4 pb-2">
        @include('layout.userLayout.footer')
    </footer>

    @include('includes.userLink.jsLink')

    @yield('code')

</body>

</html>
