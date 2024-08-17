@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Catég AC </title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6 mt-2">
        <h1 class="m-0 text-dark">Liste des catégories d'A.C</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.categorie.list') }}">Catégorie</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-lg-4">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Ajouter une nouvelle catégorie d'AC</h3>
            </div>

            <form role="form" method="POST" action="{{ Route('admin.categorie.add')  }}">
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <label for="titel">Title</label>
                        <input type="text" name="title" class="form-control" id="titel" value="{{ @old('title')  }}"
                            placeholder="Ex: Fonction Publique">
                        @error('title')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="abrev">Abréviation</label>
                        <input type="text" name="abrev" class="form-control" id="abrev" placeholder="Ex: FP1"
                            value="{{ @old('abrev')  }}">
                        <small id="abrev" class="text-muted">Ne doit pas depasser 5 characters</small> <br>
                        @error('abrev')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>
                </div>
            </form>

        </div>
    </div>


    <div class="col-lg-8">
        @if(Session::get('msg-success'))
        <div class="alert">
            <div class="alert alert-success" role="alert">
                <strong>{{ Session::get('msg-success') }}</strong>
            </div>
        </div>
        @endif

        @if(Session::get('msg-refuse'))
        <div class="alert">
            <div class="alert alert-warning" role="alert">
                <strong>{{ Session::get('msg-refuse') }}</strong>
            </div>
        </div>
        @endif

        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Voir toutes les catégories d'AC</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Titre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $item)
                        <tr>
                            <td>{{ $item->abreviation }}</td>
                            <td>{{ $item->title }}</td>
                            <td class="text-center" >
                                <!--button class="btn btn-primary"><i class="fa-solid fa-eye"></i></button-->

                                <a title="Modifier" href="{{ Route('admin.categorie.edit' , $item->id ) }}">
                                    <button title="Modifier la catégorie" class="btn btn-secondary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </a>

                                <button title="Supprimer la catégorie" class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
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
