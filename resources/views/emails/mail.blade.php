<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation de Compte</title>
    <!-- Lien vers Tailwind CSS depuis un CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom LinkedIn style -->
    <style>
        .bg-linkedin {
            background-color: #0077b5;
        }

        .text-linkedin {
            color: #0077b5;
        }

        .hover\:bg-linkedin:hover {
            background-color: #005582;
        }

        .font-linkedin {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 font-linkedin">

    <div class="container mx-auto max-w-md mt-12 bg-white p-6 rounded-lg shadow-md">
        <!-- Logo -->
        <img src="https://leconsultant.bj/assets/img/Logoconsultant%201.png" alt="Logo Consultant"
            class="w-32 mx-auto mb-6">

        <!-- Titre -->
        <h2 class="text-2xl font-bold text-center text-linkedin mb-4">
            Bonjour {{ $nom }}
        </h2>

        <!-- Message d'activation -->
        <p class="text-base text-gray-800 mb-6 text-center leading-relaxed">
            Pour activer votre compte et accéder à toutes les fonctionnalités, veuillez cliquer sur le bouton ci-dessous :
        </p>

        <!-- Bouton d'activation -->
        <div class="text-center mb-6">
            <a href="{{ $url }}" class="inline-block bg-linkedin hover:bg-linkedin text-white font-semibold py-2 px-6 rounded-full transition-colors">
                Activer mon compte
            </a>
        </div>

        <!-- Alternative avec lien complet -->
        <p class="text-gray-600 text-center mb-4">
            Si le bouton ne fonctionne pas, copiez et collez le lien suivant dans votre navigateur :
        </p>

        <!-- Lien complet -->
        <div class="bg-gray-100 p-3 rounded-md text-center text-sm text-gray-700 break-words">
            <a href="{{ $url }}" class="text-linkedin break-words">{{ $url }}</a>
        </div>

        <!-- Note sur la durée du lien -->
        <p class="text-gray-500 text-xs text-center mt-4">
            <small>Ce lien est valide pour 30 minutes.</small>
        </p>

        <!-- Section LinkedIn -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 mb-2">Suivez-nous pour plus d'informations et de mises à jour :</p>
            <a href="https://www.linkedin.com/company/leconsultant-bj" target="_blank"
                class="inline-block bg-linkedin hover:bg-linkedin text-white font-bold py-2 px-4 rounded-full">
                Suivez-nous sur LinkedIn
            </a>
        </div>
    </div>

</body>

</html>