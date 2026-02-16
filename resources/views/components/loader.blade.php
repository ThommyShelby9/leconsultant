<!-- Loader global -->
<div id="global-loader" style="display: none;">
    <div class="loader-overlay"></div>
    <div class="loader-container">
        <div class="loader-spinner"></div>
        <p class="loader-text">Chargement en cours...</p>
    </div>
</div>

<style>
    #global-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 99999;
    }

    .loader-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
    }

    .loader-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .loader-spinner {
        width: 60px;
        height: 60px;
        border: 6px solid #f3f3f3;
        border-top: 6px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .loader-text {
        color: #333;
        font-size: 16px;
        font-weight: 600;
        margin: 0;
    }
</style>

<script>
    // Fonction pour afficher le loader
    window.showLoader = function(text = 'Chargement en cours...') {
        const loader = document.getElementById('global-loader');
        const loaderText = loader.querySelector('.loader-text');
        loaderText.textContent = text;
        loader.style.display = 'block';
        console.log('🔄 Loader shown:', text);
    };

    // Fonction pour masquer le loader
    window.hideLoader = function() {
        const loader = document.getElementById('global-loader');
        loader.style.display = 'none';
        console.log('✅ Loader hidden');
    };

    // Auto-show loader sur soumission de formulaires
    document.addEventListener('DOMContentLoaded', function() {
        // Intercepter toutes les soumissions de formulaires
        document.addEventListener('submit', function(e) {
            const form = e.target;

            // Ne pas afficher le loader pour les formulaires avec data-no-loader
            if (form.hasAttribute('data-no-loader')) {
                return;
            }

            // Afficher le loader
            const submitButton = form.querySelector('[type="submit"]');
            const loaderText = submitButton?.getAttribute('data-loader-text') || 'Traitement en cours...';
            showLoader(loaderText);

            console.log('📝 Form submitted, loader shown');
        });

        // Masquer le loader si la page se recharge
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                hideLoader();
            }
        });

        // Masquer le loader après le chargement de la page
        window.addEventListener('load', function() {
            hideLoader();
        });
    });
</script>
