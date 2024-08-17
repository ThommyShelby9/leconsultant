@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Offres</title>
@livewireStyles()
@endsection

@section('titre')



<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Publier un appel d'offre</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.offre.list') }}">Les offres</a></li>
            <li class="breadcrumb-item active">Publier</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Publier un appel d'offre</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="px-4 pb-5 pt-3" method="POST" action="{{ Route('admin.offre.save') }}" enctype="multipart/form-data" >
                @csrf

                <div class="form-row">
                    <div class="col-sm-12  col-md-4">
                        <div class="form-group">
                            <label for="reference">Reference de l'offre</label>
                            <input type="text" name="reference" id="" class="form-control" value="{{@old('reference')}}" >
                            @error('reference')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="titre">Titre de l'appel d'offre</label>
                            <input type="text" name="titre" id="" class="form-control" value="{{ @old('titre')}}" >
                            @error('titre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12  col-md-4">
                        <div class="form-group">
                            <label for="depot">Lieu de Depot des candidatures</label>
                            <input type="text" name="depot" id="" class="form-control" value="{{ @old('depot')}}" >
                            @error('depot')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>


                @livewire("ac-by-categorie")


                <div class="form-row">
                    <div class="col-sm-12  col-md-4">
                        <div class="form-group">
                            <label for="marche">Type de marché</label>
                            <select name="marche" id="" class="form-control" onselected="">
                                <option value="">Choisir</option>
                                @foreach ($les_types_marches as $item)
                                    <option value="{{ $item->id }}">{{$item->title}}</option>
                                @endforeach
                            </select>
                            @error('marche')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12  col-md-4">
                        <div class="form-group">
                            <label for="dateOuv">Date Ouverture</label>
                            <input type="date" name="dateOuv" id="" class="form-control" value="{{ @old('dateOuv') }}" >
                            @error('dateOuv')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="categorie">Heure d'Ouverture</label>
                            <input type="time" name="heureOuv" id="" class="form-control" value="{{ @old('heureOuv') }}" >
                            @error('heureOuv')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-sm-12  col-md-4">
                        <div class="form-group">
                            <label for="categorie">Date Expiration</label>
                            <input type="date" name="dateExp" id="" class="form-control" value="{{ @old('dateExp') }}" >
                            @error('dateExp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="fichier">Fichier pdf</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="fichier">
                                    <label class="custom-file-label" for="logo">Choisir</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Chosir</span>
                                </div>
                            </div>
                            @error('fichier')
                            <span class="text-danger">{{ $message}}</span>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="form-row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </div>

            </form>

        </div>

    </div>
</div>



@endsection

@section('code')
@livewireScripts()


@endsection
