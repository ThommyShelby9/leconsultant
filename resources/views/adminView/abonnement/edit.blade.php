@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Abonnement </title>
@endsection

@section('titre')

<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Modifier un Abonnement</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.pack.list') }}">Abonnement</a></li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">

    <div class="offset-lg-2 col-lg-8 offset-lg-2">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Modifier un abonnement</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ Route('admin.pack.edit.save')}}" method="POST" >
                @csrf

                <input type="hidden" name="id" value="{{ $pack->id }}" >
                <div class="card-body">
                    <div class="form-group">
                      <label for="">Titre de l'Abonnement</label>
                      <input type="text" name="titre" id="" class="form-control" value="{{ @old('titre',$pack->titre) }}" placeholder="Ex: Premium, Pass Gold, Diamand" >
                      @error('titre')
                          <span>{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-row">
                        <div class="col-lg-4" id="payant_prix" >
                            <div class="form-group">
                              <label for="">Prix (cfa) </label>
                              <input type="text" name="prix" id="" class="form-control" value="{{ @old('prix',$pack->prix) }}">
                            </div>
                        </div>
                        <div class="col-lg-4" id="payant_mod" >
                            <div class="form-group">
                              <label for="">Modalité  </label>
                              <input class="form-control" type="text" name="modalite" value="Mois" id="" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary px-3">Modifier</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('code')
<script>

</script>
@endsection
