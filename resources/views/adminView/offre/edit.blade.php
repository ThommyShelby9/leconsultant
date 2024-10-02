@extends('layout.adminLayout.template')

@section('titre-site')
<title>Leconsultant| Offres</title>
@endsection

@section('titre')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Modifier un appel d'offre</h1>
    </div>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
            <li class="breadcrumb-item"><a href="#">Offre</a></li>
            <li class="breadcrumb-item active">Modifier</li>
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
                <h3 class="card-title">Modifier un appel d'offre</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="px-4 pb-5 pt-3" method="POST" action="{{ Route('admin.offre.save.edit') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $offre->id }}">
                <div class="form-row">
                    <div class="col-sm-12  col-md-4">
                        <div class="form-group">
                            <label for="reference">Reference de l'offre</label>
                            <input type="text" name="reference" id="" class="form-control" value="{{@old('reference', $offre->reference)}}">
                            @error('reference')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="titre">Titre de l'appel d'offre</label>
                            <input type="text" name="titre" id="" class="form-control" value="{{ @old('titre',$offre->titre)}}">
                            @error('titre')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12  col-md-4">
                        <div class="form-group">
                            <label for="depot">Lieu de Depot des candidatures</label>
                            <input type="text" name="depot" id="" class="form-control" value="{{ @old('depot',$offre->lieu_depot)}}">
                            @error('depot')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="form-row">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="domaineActivite">Domaine d'Activité</label>
                            <select name="domaineActivite" id="domaineActivite" class="form-control">
                                <option value="">Sélectionnez un domaine d'activité</option>
                                @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('domaineActivite') == $type->id ? 'selected' : '' }}>
                                    {{ $type->title }}
                                </option>
                                @endforeach
                            </select>
                            @error('domaineActivite')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-sm-12  col-md-4">
                        <div class="form-group">
                            <label for="categorie">Catégorie</label>
                            <select name="categorie" id="categorie" class="form-control" onchange="AfficherAC()">
                                <option value="">Choisir</option>
                                @foreach ($les_categories as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('categorie')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12  col-md-4">
                        <div class="form-group">
                            <label for="autorite">Autorité</label>
                            <select name="autorite" id="autorite" class="form-control" onchange="AfficherServ()">
                                <!--Dynamiquement remplir avec du JS  -->
                            </select>
                            <small id="helpId" class="text-muted">Choisissez la catégorie pour faire afficher les A.C</small>
                            @error('autorite')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="service">Service</label>
                            <select name="service" id="service" class="form-control">
                                <!--Dynamiquement remplir avec du JS  -->
                            </select>
                            @error('service')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-sm-12  col-md-4">
                        <div class="form-group">
                            <label for="marche">Type de marché</label>
                            <select name="marche[]" id="" class="form-control" onselected="">
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
                            <input type="date" name="dateOuv" id="" class="form-control" value="{{ @old('dateOuv',$offre->dateOuverture) }}">
                            @error('dateOuv')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="categorie">Heure d'Ouverture</label>
                            <input type="time" name="heureOuv" id="" class="form-control" value="{{ @old('heureOuv',$offre->heureOuverture) }}">
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
                            <input type="date" name="dateExp" id="" class="form-control" value="{{ @old('dateExp',$offre->dateExpiration) }}">
                            @error('dateExp')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="fichier">Fichier PDF</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="fichier" id="fichier">
                                    <label class="custom-file-label" for="fichier">Choisir</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Choisir</span>
                                </div>
                            </div>

                            <!-- Lien pour voir le fichier s'il existe -->
                            @if(file_exists($offre->fichier))
                            <a href="{{ asset($offre->fichier) }}">Voir le fichier</a>
                            @else
                            <span><b>Aucun fichier</b></span>
                            @endif

                            @error('fichier')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Barre de progression -->
                        <div class="progress" style="height: 25px; margin-top: 10px; display: none;" id="progress-bar-container">
                            <div class="progress-bar" id="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                    </div>


                </div>

                <div class="form-row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Sauvegarder les changements</button>
                    </div>
                </div>

            </form>

        </div>

    </div>
</div>
@endsection

@section('code')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
    // Affichage du nom du fichier sélectionné dans l'input
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("fichier").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>

<script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            e.preventDefault(); // Empêche la soumission classique du formulaire

            var formData = new FormData(this);
            var fileInput = $('#fichier').val();

            if (fileInput) {
                $('#progress-bar-container').show(); // Afficher la barre de progression
                console.log("Affichage de la barre de progression");


                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();

                        // Suivre la progression de téléchargement
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                $('#progress-bar').css('width', percentComplete + '%');
                                $('#progress-bar').text(percentComplete + '%');
                                $('#progress-bar').attr('aria-valuenow', percentComplete);
                            }
                        }, false);

                        return xhr;
                    },
                    type: 'POST',
                    url: '{{ route("admin.offre.save.edit") }}', // Changez l'URL selon votre route
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#progress-bar').css('width', '100%');
                        $('#progress-bar').text('100%');
                        $('#progress-bar').attr('aria-valuenow', 100);

                        // Afficher la notification de succès
                        Swal.fire({
                            icon: 'success',
                            title: 'Fichier téléchargé avec succès!',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        // Optionnel : rediriger après un délai
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.offre.list') }}";
                        }, 2000);
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur lors du téléchargement',
                            text: response.responseJSON.message,
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Veuillez sélectionner un fichier à télécharger',
                });
            }
        });
    });
</script>

<script>
    function AfficherServ() {
        var idAc = document.getElementById('autorite').value;


        if (idAc != 0) {

            col = '<option value="Toutes les directions">Toutes les directions</option>';
            $("#service").empty();
            $("#service").append(col);

            $(function() {
                var _token = '<?php echo csrf_token(); ?>';
                $.ajax({
                    url: '/ajax-direction',
                    data: {
                        idAc: idAc,
                        _token
                    },
                    dataType: 'JSON',
                    type: 'POST',
                    success: function(data) {
                        //alert(data);
                        var col;
                        data.forEach(element => {
                            col = '<option value="' + element['abreviation'] + '">' + element['name'] + '</option>';
                            $("#service").append(col);
                        });

                    }
                });
            })

        } else {

            $("#service").empty();
        }
    }


    function AfficherAC() {
        var idCateg = document.getElementById('categorie').value;

        if (idCateg != 0) {

            col = '<option value="null">Choisir A.C</option>';
            $("#autorite").empty();
            $("#autorite").append(col);

            $(function() {
                var _token = '<?php echo csrf_token(); ?>';
                $.ajax({
                    url: '/ajax-ac',
                    data: {
                        idCateg: idCateg,
                        _token
                    },
                    dataType: 'JSON',
                    type: 'POST',
                    success: function(data) {

                        var col;
                        data.forEach(element => {
                            col = '<option value="' + element['id'] + '">' + element['name'] + '</option>';
                            $("#autorite").append(col);
                        });

                    }
                });
            })

        } else {

            $("#autorite").empty();
            $("#service").empty();
        }
    }
</script>
@endsection