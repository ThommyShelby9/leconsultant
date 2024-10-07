<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Alerte Correspondante</title>
    <style>
        body {
            background-color: #f3f2ef;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .header img {
            width: 150px;
        }
        h2 {
            color: #0073b1;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p.lead {
            font-size: 16px;
            color: #333333;
            margin-bottom: 20px;
        }
        ul.list-group {
            list-style-type: none;
            padding-left: 0;
            margin-bottom: 20px;
        }
        ul.list-group li {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            margin-bottom: 8px;
        }
        .btn-primary {
            background-color: #0073b1;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            font-size: 14px;
            margin-right: 10px;
        }
        .btn-secondary {
            background-color: #f3f2ef;
            color: #333333;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            font-size: 14px;
        }
        .btn-primary:hover {
            background-color: #005582;
        }
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
        .text-muted {
            color: #666666;
            font-size: 12px;
            text-align: center;
            margin-top: 30px;
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <img src="https://leconsultant.bj/assets/img/Logoconsultant%201.png" alt="Logo Consultant">
        </div>

        <h2>Bonjour {{ $user->nom }} {{ $user->prenoms }},</h2>

        <p class="lead">
            Une nouvelle offre correspond à vos critères d'alerte :
        </p>

        <ul class="list-group">
            <li class="list-group-item"><strong>Titre:</strong> {{ $offre->titre }}</li>
            <li class="list-group-item"><strong>Service:</strong> {{ $offre->service }}</li>
            <li class="list-group-item"><strong>Lieu de dépôt:</strong> {{ $offre->lieu_depot }}</li>
            <li class="list-group-item"><strong>Autorité Contractante:</strong> {{ $autorite }}</li>
            <li class="list-group-item"><strong>Date d'ouverture:</strong> {{ $offre->dateOuverture }}</li>
            <li class="list-group-item"><strong>Heure d'ouverture:</strong> {{ $offre->heureOuverture }}</li>
            <li class="list-group-item"><strong>Date d'expiration:</strong> {{ $offre->dateExpiration }}</li>
        </ul>

        <div class="text-center">
            <a href="{{ $lien_offre }}" class="btn-primary">Voir l'offre</a>
            <a href="{{ $fichier_offre }}" class="btn-secondary">Télécharger l'appel d'offre</a>
        </div>

        <div class="text-muted">
            <small>Merci d'utiliser notre service!</small>
        </div>
    </div>

</body>
</html>
