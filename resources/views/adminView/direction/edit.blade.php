@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Diections AC </title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Créer une Direction/Service</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.direction.list') }}">Directions / Services</a></li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="offset-lg-3 col-lg-6 mt-2">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Ajouter une Direction/Service à cette A.C</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ Route('admin.direction.edit.save') }}" method="POST">

                @csrf
                <input type="hidden" name="id" value="{{$direction->id}}" >

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="">Catégorie d'Autorité contractante</label><label for=""></label>
                            <select name="categorie" id="categorie" class="form-control"  onchange="AfficherAC()"  >
                                <option value="">Choisir</option>
                                @foreach ($les_categories as $item)
                                <option value="{{ $item->id }}" >{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <label for="autorite">Autorité contractante concernée</label><label for=""></label>
                            <select name="autorite" id="autorite" class="form-control" >
                                <!--Dynamiquement remplir avec du JS  -->
                            </select>
                            <small id="helpId" class="text-muted">Choisissez la catégorie pour faire afficher les A.C</small>
                            @error('autorite')
                                <span class="text-danger">Veillez choisir une A.C</span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="nom">Nom de la Direction / Service</label>
                        <input type="text" class="form-control" name="nom" placeholder="Ex: Direction des ...." value="{{ @old('nom',$direction->name)}}" >
                        @error('nom')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="abrev">Abreviation</label>
                        <input type="text" name="abrev" class="form-control" id="abrev" placeholder="Ex: DSI" value="{{ @old('abrev',$direction->abreviation)}}" >
                        @error('abrev')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary px-4">Sauvegarder les changements</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('code')
<script>
    function AfficherAC(){
        var idCateg = document.getElementById('categorie').value;

        if(idCateg != 0){

           col='<option value="">Choisir A.C</option>';
           $("#autorite").empty();
           $("#autorite").append(col);

            $(function(){
                var _token = '<?php echo csrf_token(); ?>';
                $.ajax({
                    url:"{{ route ('ajax-ac')}}",
                    data:{
                        idCateg: idCateg,
                        _token
                    },
                    dataType: 'JSON',
                    type:'POST',
                    encode  : true,
                    success:function(data){

                        var col ;
                        data.forEach(element => {
                            col='<option value="'+element['id']+'">'+element['name']+'</option>';
                            $("#autorite").append(col);
                        });

                    }
                });
            })

        }else{

            $("#autorite").empty();
        }
    }

</script>
@endsection

