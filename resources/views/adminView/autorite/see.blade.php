@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| A.C </title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Voir en détails une A.C</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.ac.list') }}">Autorité C.</a></li>
            <li class="breadcrumb-item active">Voir en détails</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-lg-5 mt-4">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">A Propos de la Direction / Service</h3>
            </div>

            @foreach ($info as $item)
            <div class="card-body">
                <p class="text-center">
                    <img src="{{ asset($item->logo) }}" alt="">
                </p>
                <strong><i class="fas fa-book mr-1"></i>Nom</strong>

                <p class="text-muted">
                    {{$item->name}} <br>
                    <b>{{$item->abreviation}}</b>
                </p>

                <hr>

                <strong><i class="fas fa-book mr-1"></i>Catégorie</strong>

                <p class="text-muted">
                    {{$item->title}}
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Localisation</strong>

                <p class="text-muted">{{$item->localisation}}</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Contacts</strong>

                <p class="text-muted">
                    <span class="tag tag-danger">+229 {{$item->contact}}</span> <br>
                    <span class="tag tag-success">{{$item->email}}</span>
                </p>

                <hr>

                <!--strong><i class="far fa-file-alt mr-1"></i> Logo</strong>

                <p class="text-muted">{{$item->logo }}</p-->
            </div>
            @endforeach
        </div>
    </div>

    <div class="col-lg-7">
        <div class="col-12 mt-4">
            @if(Session::get('msg-success'))
            <div class="alert">
                <div class="alert alert-success" role="alert">
                    <strong>{{ Session::get('msg-success') }}</strong>
                </div>
            </div>
            @endif
        </div>

        <div class="col-12">

            <div class="card card-navy">
                <div class="card-header">
                    <h3 class="card-title">Liste des Directions/Services de cette A.C</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Nom Direction</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($directions as $item)
                            <tr>

                                <td>{{ $item->abreviation }}</td>
                                <td>{{ $item->name }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
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
