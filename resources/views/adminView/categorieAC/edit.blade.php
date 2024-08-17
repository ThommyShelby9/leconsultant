@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Catég AC </title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6 mt-2">
        <h1 class="m-0 text-dark">Modifier une catégories d'A.C</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.categorie.add') }}">Catégorie</a></li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-lg-4">

        @if(Session::get('msg-refuse'))
        <div class="alert">
            <div class="alert alert-warning" role="alert">
                <strong>{{ Session::get('msg-refuse') }}</strong>
            </div>
        </div>
        @endif

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Modifier une catégorie d'AC</h3>
            </div>

            <form role="form" method="POST" action="{{ Route('admin.categorie.edit.save')  }}">
                @csrf
                <input type="hidden" name="id" value="{{ $categorie->id }}" >

                <div class="card-body">
                    <div class="form-group">
                        <label for="titel">Title</label>
                        <input type="text" name="title" class="form-control" id="titel" value="{{ @old('title', $categorie->title )  }}"
                            placeholder="Ex: Fonction Publique">
                        @error('title')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="abrev">Abréviation</label>
                        <input type="text" name="abrev" class="form-control" id="abrev" placeholder="Ex: FP1"
                            value="{{ @old('abrev', $categorie->abreviation )  }}">
                        <small id="abrev" class="text-muted">Ne doit pas depasser 5 characters</small> <br>
                        @error('abrev')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Modifier</button>
                    </div>
                </div>
            </form>

        </div>
    </div>



</div>
@endsection

@section('code')


<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

</script>

@endsection
