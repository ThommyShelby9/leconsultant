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
            <div id="logo" class="flex justify-between">
                <a href="{{ Route('welcome') }}">
                    <img src="{{ asset('assets/img/Logoconsultant%201.png')}}" alt="" class="">
                </a>
                <div class="block lg:hidden flex justify-center items-center lg:my-0 my-2">
                    <!--                    <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-consultant-blue border-consultant-blue">-->
                    <!--                        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path></svg>-->
                    <!--                    </button>-->
                    <button id="nav-toggle" aria-label="Toggle navigation" aria-expanded="false"
                        class="relative flex items-center w-5 h-5 justify-center rounded cursor-pointer">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>

            <ul id="main-menu-navigation"
                class="lg:flex flex lg:flex-row flex-col hidden lg:items-center items-start lg:w-max">

                <li class="text-consultant-blue text-lg font-medium px-7 py-2 active">
                    <a href="{{ Route('welcome') }}">
                        Accueil
                    </a>
                </li>
                <li class="text-consultant-blue text-lg font-medium px-7 py-2">
                    <a href="{{ Route('offre') }}">
                        Appel d'Offres
                    </a>
                </li>
                

                @auth
                <li class="text-consultant-blue text-lg font-medium px-7 py-2">
                    <a href="{{ route('register.morale') }}">
                        Mon compte
                    </a>
                </li>
                <li class="text-consultant-rouge text-lg font-medium px-7 py-2">
                    <a href="{{ route('admin.logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Deconnecter
                    </a>

                </li>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                </form>

                @else
                <li class="text-consultant-blue text-lg font-medium px-7 py-2">
                    <a href="{{ Route('login') }}">
                        Se connecter
                    </a>
                </li>
                <li class="">
                    <a href="{{ Route('register.morale') }}">
                        S'inscrire
                    </a>
                </li>
                @endauth
            </ul>
        </nav>

        @yield('banner')
    </header>

    <main class="{{request()->routeIs('register.*') ? 'relative bg-consultant-gris2' : 'relative py-12'}}">
        @yield('contenu')
    </main>

    <footer class="relative">
    </footer>

    @include('includes.userLink.jsLink')

    @yield('code')

    @include('components.loader')

</body>

</html>
