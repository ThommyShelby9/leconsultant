<!-- resources/views/emails/alerte_notification.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Alerte Correspondante</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa; font-family: Arial, sans-serif;">
    <div class="container" style="max-width: 600px; margin: 50px auto;">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <!-- Ajouter une image ici avec CID -->
                <img src="https://leconsultant.bj/assets/img/Logoconsultant%201.png" alt="Image Description" class="img-fluid mb-4">
                
                <h2 class="card-title text-center text-primary">
                    Bonjour {{ $user->nom }} {{ $user->prenoms }},
                </h2>
                <p class="lead">
                    Une nouvelle offre correspond à vos critères d'alerte :
                </p>

                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Titre:</strong> {{ $offre->titre }}</li>
                    <li class="list-group-item"><strong>Service:</strong> {{ $offre->service }}</li>
                    <li class="list-group-item"><strong>Lieu de dépôt:</strong> {{ $offre->lieu_depot }}</li>
                    <li class="list-group-item"><strong>Autorité Contractante:</strong> {{ $autorite }}</li> <!-- Nom de l'autorité contractante -->
                    <li class="list-group-item"><strong>Date d'ouverture:</strong> {{ $offre->dateOuverture }}</li>
                    <li class="list-group-item"><strong>Heure d'ouverture:</strong> {{ $offre->heureOuverture }}</li>
                    <li class="list-group-item"><strong>Date d'expiration:</strong> {{ $offre->dateExpiration }}</li>
                </ul>

                <div class="text-center">
                    <a href="{{ $lien_offre }}" class="btn btn-primary mb-3">Voir l'offre</a>
                    <a href="{{ $fichier_offre }}" class="btn btn-secondary">Télécharger l'appel d'offre</a> <!-- Bouton de téléchargement -->
                </div>

                <p class="text-muted mt-4">
                    <small>Merci d'utiliser notre service!</small>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
