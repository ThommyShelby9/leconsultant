<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification du paiement - LeConsultant</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .spinner {
            width: 80px;
            height: 80px;
            border: 8px solid #f3f3f3;
            border-top: 8px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 30px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 15px;
        }

        p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .status {
            margin: 30px 0;
            padding: 15px;
            background: #f0f4ff;
            border-radius: 10px;
            color: #667eea;
            font-weight: 600;
        }

        .status.success {
            background: #d4edda;
            color: #155724;
        }

        .status.error {
            background: #f8d7da;
            color: #721c24;
        }

        .details {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            text-align: left;
        }

        .details div {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .details div:last-child {
            border-bottom: none;
        }

        .details strong {
            color: #333;
        }

        .details span {
            color: #666;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #5568d3;
        }

        .note {
            margin-top: 20px;
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="spinner" id="spinner"></div>

        <h1 id="title">Vérification de votre paiement...</h1>

        <p id="message">
            Veuillez patienter pendant que nous vérifions votre paiement.
            Cette opération peut prendre quelques secondes.
        </p>

        <div class="status" id="status">
            En attente de confirmation...
        </div>

        <div class="details">
            <div>
                <strong>Transaction ID:</strong>
                <span>{{ substr($transaction->id, 0, 13) }}...</span>
            </div>
            <div>
                <strong>Montant:</strong>
                <span>{{ number_format($transaction->amount, 0, ',', ' ') }} FCFA</span>
            </div>
            <div>
                <strong>Type:</strong>
                <span>{{ $transaction->type === 'subscription' ? 'Abonnement' : 'Formation' }}</span>
            </div>
            <div>
                <strong>Statut actuel:</strong>
                <span id="current-status">{{ $transaction->status }}</span>
            </div>
        </div>

        <div id="action-buttons" style="display: none;">
            <a href="{{ route('moncompte') }}" class="btn">Accéder à mon compte</a>
        </div>

        <p class="note">
            Cette page se met à jour automatiquement.
        </p>
    </div>

    <script>
        console.log('🔍 Payment waiting page loaded');
        console.log('Transaction ID: {{ $transaction->id }}');
        console.log('Initial status: {{ $transaction->status }}');

        let checkCount = 0;
        const maxChecks = 60; // 60 vérifications = 5 minutes max
        let checkInterval;

        // Fonction pour vérifier le statut de la transaction
        function checkTransactionStatus() {
            checkCount++;
            console.log(`🔄 Check #${checkCount} - Fetching transaction status...`);

            fetch('/payment/status/{{ $transaction->id }}')
                .then(response => {
                    console.log('📡 Response status:', response.status);
                    console.log('📡 Response headers:', response.headers.get('content-type'));

                    // Lire le texte brut de la réponse
                    return response.text().then(text => {
                        console.log('📄 Raw response text:', text.substring(0, 500)); // Log premiers 500 caractères

                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('❌ JSON parse error:', e);
                            console.error('❌ Full response:', text);
                            throw new Error('Invalid JSON response: ' + text.substring(0, 200));
                        }
                    });
                })
                .then(data => {
                    console.log('✅ Status response:', data);

                    if (data.success) {
                        const status = data.transaction.status;
                        const statusElement = document.getElementById('current-status');
                        statusElement.textContent = status;

                        if (status === 'COMPLETED') {
                            console.log('✅ Payment COMPLETED!');
                            handleSuccess();
                        } else if (status === 'FAILED' || status === 'CANCELLED') {
                            console.log('❌ Payment FAILED or CANCELLED');
                            handleFailure(status);
                        } else {
                            console.log(`⏳ Status still: ${status}`);
                        }
                    }
                })
                .catch(error => {
                    console.error('❌ Error checking status:', error);
                });

            // Arrêter après maxChecks tentatives
            if (checkCount >= maxChecks) {
                console.log('⏰ Max checks reached');
                clearInterval(checkInterval);
                handleTimeout();
            }
        }

        // Gestion du succès
        function handleSuccess() {
            clearInterval(checkInterval);

            document.getElementById('spinner').style.display = 'none';
            document.getElementById('title').textContent = '✅ Paiement confirmé !';
            document.getElementById('message').textContent = 'Votre paiement a été traité avec succès. Vous allez être redirigé vers votre compte...';

            const statusDiv = document.getElementById('status');
            statusDiv.className = 'status success';
            statusDiv.textContent = 'Paiement réussi';

            document.getElementById('action-buttons').style.display = 'block';

            console.log('🎉 Redirecting to account in 3 seconds...');
            setTimeout(() => {
                window.location.href = '{{ route('moncompte') }}?payment=success';
            }, 3000);
        }

        // Gestion de l'échec
        function handleFailure(status) {
            clearInterval(checkInterval);

            document.getElementById('spinner').style.display = 'none';
            document.getElementById('title').textContent = '❌ Paiement échoué';
            document.getElementById('message').textContent = 'Votre paiement n\'a pas pu être traité. Veuillez réessayer.';

            const statusDiv = document.getElementById('status');
            statusDiv.className = 'status error';
            statusDiv.textContent = `Statut: ${status}`;

            document.getElementById('action-buttons').innerHTML = '<a href="{{ route('mesAbonnements') }}" class="btn">Retour aux abonnements</a>';
            document.getElementById('action-buttons').style.display = 'block';
        }

        // Gestion du timeout
        function handleTimeout() {
            document.getElementById('spinner').style.display = 'none';
            document.getElementById('title').textContent = '⏰ Vérification en cours...';
            document.getElementById('message').textContent = 'La vérification prend plus de temps que prévu. Votre paiement sera validé sous peu. Vous pouvez vérifier votre compte.';

            const statusDiv = document.getElementById('status');
            statusDiv.textContent = 'Vérification en attente - Consultez vos abonnements';

            document.getElementById('action-buttons').style.display = 'block';
        }

        // Vérifier immédiatement le statut initial
        const initialStatus = '{{ $transaction->status }}';
        console.log('Initial status from server:', initialStatus);

        if (initialStatus === 'COMPLETED') {
            console.log('✅ Already completed on page load!');
            handleSuccess();
        } else if (initialStatus === 'FAILED' || initialStatus === 'CANCELLED') {
            console.log('❌ Already failed on page load');
            handleFailure(initialStatus);
        } else {
            // Démarrer la vérification toutes les 5 secondes
            console.log('⏱️ Starting periodic checks every 5 seconds');
            checkInterval = setInterval(checkTransactionStatus, 5000);

            // Première vérification immédiate
            setTimeout(checkTransactionStatus, 2000);
        }
    </script>
</body>
</html>
