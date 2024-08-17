@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Abonnement </title>
@endsection

@section('titre')

<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Créer un Abonnement</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.pack.list') }}">Abonnement</a></li>
            <li class="breadcrumb-item active">Créer un ouveau</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">

    <div class="offset-lg-2 col-lg-8 offset-lg-2">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Creer un abonnement</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <kkiapay-widget amount="150"
                key="85abcb60ae8311ecb9755de712bc9e4f"
                url="<url-vers-votre-logo>" position="center" sandbox="true" data="Essaie1"
                callback="<url-de-redirection-quand-lepaiement-est-reuissi>">
            </kkiapay-widget>

            <kkiapay-widget
                amount="850"
                key="85abcb60ae8311ecb9755de712bc9e4f"
                url="<url-vers-votre-logo>"
                    position="center" sandbox="true"
                    data=""
                callback="{{ route('admin.home2', 12 ) }} ">
            </kkiapay-widget>

            <kkiapay-widget
            amount="1250"
                key="85abcb60ae8311ecb9755de712bc9e4f"
                url="<url-vers-votre-logo>" position="center" sandbox="true" data="Essaie3"
                callback="<url-de-redirection-quand-lepaiement-est-reuissi>">
            </kkiapay-widget>

        </div>
    </div>

</div>
@endsection


@section('code')

<script src="https://cdn.kkiapay.me/k.js"></script>


@endsection
