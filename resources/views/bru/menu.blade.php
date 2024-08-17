<ul class="navbar-nav ml-auto">

    <li class="nav-item">
        <a class="nav-link t" style="" href="{{ Route('welcome') }}">Acceuil</a>
    </li>
    <li class="nav-item">
        <a class="nav-link t" href="{{ Route('offre') }}">Appel d'Offres</a>
    </li>
    <li class="nav-item">
        <a class="nav-link t" href="{{ Route('pageFormation') }}">Formations</a>
    </li>
    <li class="nav-item">
        <a class="nav-link t" href="{{ Route('pageService') }}">Nos Services</a>
    </li>
    @auth
    <li class="nav-item">
        <a class="nav-link t" href="{{ route('moncompte') }}">Mon compte</a>
    </li>
    <li class="nav-item">
        <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link btn btn-primary px-4" href="{{ Route('register.morale') }}" style="background-color: #0140BA; color: white; ">
            Deconnecter
        </a>
    </li>
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
        @csrf
    </form>

    @else
    <li class="nav-item">
        <a class="nav-link t" href="{{ Route('login') }}">Se connecter</a>
    </li>
    <li class="nav-item">
        <a class="nav-link btn btn-primary px-4" href="{{ Route('register.morale') }}" style="background-color: #0140BA; color: white; ">
            S'inscrire
        </a>
    </li>
    @endauth


</ul>


