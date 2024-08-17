<!--request()->routeIs('')  ? 'nav-item active' : 'nav-item'  -->
<!--request()->routeIs('')  ? 'nav-link active' : 'nav-link'  -->
<ul class=" nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <li class="nav-item">
        <a href="{{Route('admin.home')}}"
        class="{{ request()->routeIs('admin.home')  ? 'nav-link active' : 'nav-link'  }}">
            <i class="fa-solid fa-house"></i>
            <p>
                Acceuil
            </p>
        </a>
    </li>

    <li class="nav-header">RESSOURCES</li>

    <li class="nav-item has-treeview
        {{request()->routeIs('admin.offre.*') ? ' menu-open' : ''}}">

        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
                Appels d'offres
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview"
            style="{{request()->routeIs('admin.offre.*') ? '  display: block' : ' display: none'}}">

            <li class="nav-item">
                <a href="{{Route('admin.offre.list')}}"
                class="{{ request()->routeIs('admin.offre.list')  ? 'nav-link active' : 'nav-link'  }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Voir Tout</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{Route('admin.offre.new')}}"
                class="{{ request()->routeIs('admin.offre.new')  ? 'nav-link active' : 'nav-link'  }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Publier</p>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item has-treeview
        {{request()->routeIs('admin.formation.*') ? ' menu-open' : ''}}">

        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
                Formations
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview"
            style="{{request()->routeIs('admin.formation.*') ? '  display: block' : ' display: none'}}">

            <li class="nav-item">
                <a href="{{Route('admin.formation.list')}}"
                class="{{ request()->routeIs('admin.formation.list')  ? 'nav-link active' : 'nav-link'  }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Voir Toutes</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{Route('admin.formation.new')}}"
                class="{{ request()->routeIs('admin.formation.new')  ? 'nav-link active' : 'nav-link'  }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Publier</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-header">GERER LE SITE WEB</li>
    <li class="nav-item">
        <a href="{{ route('adminSite.services.list') }}"
            class="{{ request()->routeIs('adminSite.services.*')  ? 'nav-link active' : 'nav-link'  }}">

            <i class="fa-solid fa-bullhorn"></i>
            <p>Page Service</p>
        </a>
    </li>

    <li class="nav-header">GENERAL</li>

    <li class="nav-item  has-treeview
            {{request()->routeIs('admin.categorie.*') ? ' menu-open' : ''}}
            {{request()->routeIs('admin.direction.*') ? ' menu-open' : ''}}
            {{request()->routeIs('admin.type.*') ? ' menu-open' : ''}}
            {{request()->routeIs('admin.ac.*') ? ' menu-open' : ''}}">


        <a href="#" class="nav-link ">
            <i class="fa-solid fa-database"></i>
            <p>
                Données Utiles
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">4</span>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">

                <a href="{{ Route('admin.categorie.list') }}"
                    class="{{request()->routeIs('admin.categorie.*')  ? 'nav-link active' : 'nav-link'}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Les Catégorie d'A.C</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ Route('admin.ac.list') }}"
                    class="{{request()->routeIs('admin.ac.*')  ? 'nav-link active' : 'nav-link'}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Les A.C</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ Route('admin.direction.list') }}"
                    class="{{request()->routeIs('admin.direction.*')  ? 'nav-link active' : 'nav-link'}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Les Services</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ Route('admin.type.list') }}"
                    class="{{request()->routeIs('admin.type.*')  ? 'nav-link active' : 'nav-link'}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Autres (Type & Domaine)</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-header">MON COMPTE</li>
    <li class="nav-item mb-5">
        <a href="{{ route('admin.logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
            <i class="nav-icon fa-solid fa-arrow-right-from-bracket"></i>
            <p>Se Deconnecter</p>
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
            @csrf
        </form>
    </li>

</ul>
