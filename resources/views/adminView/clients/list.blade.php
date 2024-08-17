@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Clients</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Les Clients</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.client.list') }}">Clients</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>
@endsection


@section('contenu')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Les Clients de Type Physique</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="physique" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prenoms</th>
                            <th>Telephone</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Compte verif.</th>
                            <th>Compte Actif</th>
                            <th>Abonnement</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($userPhys as $item)
                        <tr>
                            <td>{{$item->nom}}</td>
                            <td>{{$item->prenoms}}</td>
                            <td>{{$item->telephone}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->adresse}}</td>
                            <td>
                                @if($item->email_verified_at != null)
                                    <span class="badge bg-primary px-3">Vérifié</span>
                                @else
                                    <span class="badge bg-warning px-3">Non Verifié</span>
                                @endif
                            </td>
                            <td>
                                @if($item->isActif ==1 )
                                    <span class="badge bg-success px-3">Actif</span>
                                @elseif($item->isActif ==2)
                                    <span class="badge bg-danger px-3">Non Actif</span>
                                @endif
                            </td>
                            <td>
                                @if( $item->situation == "Mode Gratuit")
                                <span class="badge bg-orange px-3">{{$item->situation}}</span>
                                @elseif($item->situation == "Mode Essaie")
                                <span class="badge bg-secondary px-3">{{$item->situation}}</span>
                                @else
                                <span class="badge text-success px-3">{{$item->situation}}</span>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Les Clients de Type Morale</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="morale" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Type de Societe</th>
                            <th>Dénomination</th>
                            <th>Telephone</th>
                            <th>Email</th>
                            <th>Compte verif.</th>
                            <th>Compte Actif</th>
                            <th>Abonnement</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($userMor as $item)
                        <tr>
                            <td>{{$item->typeSociete}}</td>
                            <td>{{$item->nomSociete}}</td>
                            <td>{{$item->telephoneSociete}}</td>
                            <td>{{$item->email}}</td>
                            <td>
                                @if($item->email_verified_at != null)
                                    <span class="badge bg-primary px-3">Vérifié</span>
                                @else
                                    <span class="badge bg-warning px-3">Non Verifié</span>
                                @endif
                            </td>
                            <td>
                                @if($item->isActif ==1 )
                                    <span class="badge bg-success px-3">Actif</span>
                                @elseif($item->isActif ==2)
                                    <span class="badge bg-danger px-3">Non Actif</span>
                                @endif
                            </td>
                            <td>
                                @if( $item->situation == "Mode Gratuit")
                                <span class="badge bg-orange px-3">{{$item->situation}}</span>
                                @elseif($item->situation == "Mode Essaie")
                                <span class="badge bg-secondary px-3">{{$item->situation}}</span>
                                @else
                                <span class="badge text-success px-3">{{$item->situation}}</span>
                                @endif

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
        $("#physique").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $('#morale').DataTable({
            "autoWidth": false,
            "responsive": true,
        });
    });

</script>
@endsection
