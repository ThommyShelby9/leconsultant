<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Inclure SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    @if(session('subscription_inactive'))
    <script>
        Swal.fire({
            title: 'Abonnement requis',
            text: "Vous n'avez pas d'abonnement actif. Veuillez procéder au paiement pour accéder à la plateforme.",
            icon: 'warning',
            showCancelButton: false,
            confirmButtonText: 'Procéder au paiement',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            backdrop: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Rediriger l'utilisateur vers la page de paiement
                window.location.href = "";
            }
        });
    </script>
    @endif

    <!-- Votre contenu HTML habituel -->
</body>
</html>
