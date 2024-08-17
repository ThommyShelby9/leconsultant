@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Site web</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Nos services</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('adminSite.services.list') }}">Site web</a></li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ Route('adminSite.services.new') }}">
            <button class="btn btn-primary">Ajouter un service</button>
        </a>
    </div>
</div>
<div class="row">

    @foreach ($services as $item)
    <div class="col-lg-6">
        <div class="card card-widget">
            <div class="card-header">
                <div class="user-block text-primary">
                   <h5>{{$item->titre}}</h5>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="display: block;">
                <!-- post text -->
                <p>{{$item->description}}</p>


                <!-- Social sharing buttons -->
                <button type="button" class="btn btn-secondary btn-sm">
                    <i class="fas fa-share"></i> Voir
                </button>

                <a href="{{ route('adminSite.services.edit' , $item->id) }}">
                    <button type="button" class="btn btn-warning btn-sm">
                        <i class="far fa-thumbs-up"></i> Modifier
                    </button>
                </a>

                @if($item->statut == True)

                    <a href="{{ route('adminSite.hide.service',$item->id) }}" onclick="return confirm('Voulez vous-vraiment, rendre non visible ce service')">
                        <button  type="button" class="btn btn-danger btn-sm">
                            <i class="fas fa-share"></i>Ne pas aficher ça sur le site
                        </button>
                    </a>

                @elseif($item->statut == False)

                    <a href="{{ route('adminSite.show.service',$item->id) }}" onclick="return confirm('Voulez vous-vraiment, rendre visible ce service')">
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fas fa-share"></i>Rendre visible sur le site
                        </button>
                    </a>

                @endif

            </div>
        </div>
    </div>
    @endforeach



</div>
@endsection

@section('code')

@endsection
