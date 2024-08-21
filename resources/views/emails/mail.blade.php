<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation de Compte</title>
    <!-- Lien vers le CDN Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa; font-family: Arial, sans-serif;">

    <div class="container" style="max-width: 600px; margin: 50px auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <img src="{{ asset('assets/img/Logoconsultant%201.png')}}" alt="" class="">

        <h2 class="text-center text-primary">
            Bonjour {{ $nom }} 
        </h2>

        <p class="lead">
            Pour activer votre compte, veuillez <a href="{{ $url }}" class="btn btn-primary">cliquer ici</a>.
        </p>

        <p>
            Si le bouton ne fonctionne pas, veuillez copier et coller le lien ci-dessous dans votre navigateur :
        </p>

        <div class="alert alert-light" role="alert">
            <a href="{{ $url }}" class="text-break">{{ $url }}</a>
        </div>

        <p class="text-muted">
            <small>Ce lien est actif pendant 30 minutes.</small>
        </p>
    </div>

</body>
</html>
