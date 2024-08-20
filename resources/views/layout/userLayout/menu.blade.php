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
    <li class="text-consultant-blue text-lg font-medium px-7 py-2">
        <a href="{{ Route('pageFormation') }}">
            Formations
        </a>
    </li>
    <li class="text-consultant-blue text-lg font-medium px-7 py-2">
        <a href="{{ Route('pageService') }}">
            Nos services
        </a>
    </li>

    @auth

    <li class="text-consultant-blue text-lg font-medium px-7 py-2">
        <a href="{{ Route('alerte') }}">
            Créer une alerte
        </a>
    </li>
    
    <li class="text-consultant-blue text-lg font-medium px-7 py-2">
        <a href="{{ route('moncompte') }}">
           Mon compte
        </a>
    </li>
    <li class="text-consultant-rouge text-lg font-medium px-7 py-2">
        <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
