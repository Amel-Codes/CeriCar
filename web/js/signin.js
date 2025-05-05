$(document).on('submit', '#signin-form', function(e) {
    e.preventDefault(); // Empêche l'envoi classique du formulaire

    const data = $(this).serialize(); // Sérialise automatiquement les données du formulaire

    $.ajax({
        url: 'index.php?r=test/signin', // URL de l'action signin
        type: 'POST',
        data: data, // Envoi des données sérialisées
        beforeSend: function(xhr) {
            // Ajoute le token CSRF dans les en-têtes de la requête
            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
        },
        success: function(response) {
            // Vérifier si des notifications sont présentes dans la réponse
            if (response.notifications) {
                response.notifications.forEach(function(notification) {
                    showNotification(notification.type, notification.message); // Afficher les notifications
                });
            }

            // Si la connexion réussit, rediriger vers la page de recherche
            if (response.notifications && response.notifications[0].type === 'success') {
                setTimeout(function() {
                    window.location.href = 'index.php?r=test/search'; // Rediriger après un délai
                }, 2000); // Attendre 2 secondes avant la redirection
            }
        },
        error: function(xhr, status, error) {
            // Gérer les erreurs (exemple : erreur réseau, erreur HTTP)
            console.error('Erreur AJAX:', error);
            showNotification('error', 'Une erreur est survenue. Veuillez réessayer plus tard.');
        }
    });
});

// Fonction pour afficher les notifications
function showNotification(type, message) {
    var banner = document.getElementById('notification-banner');
    banner.className = 'alert alert-' + type; // Appliquer la classe en fonction du type de notification
    banner.textContent = message;
    banner.style.display = 'block'; // Afficher le bandeau avec une transition douce
    banner.style.opacity = 0; // Démarre avec une opacité nulle (invisible)

    setTimeout(() => {
        banner.style.opacity = 1; // Fait apparaître le bandeau avec un effet de fondu
        banner.style.transform = 'translateY(0)'; // Fait descendre le bandeau
    }, 10); // Délai très court pour appliquer l'opacity à 0 avant la transition

    // Cacher la notification après 3 secondes
    setTimeout(() => {
        banner.style.opacity = 0; // Fait disparaître le bandeau avec un fondu
        banner.style.transform = 'translateY(-10px)'; // Remonte légèrement le bandeau avant de le cacher
        setTimeout(() => {
            banner.style.display = 'none'; // Cache le bandeau une fois l'animation terminée
        }, 500); // Durée de l'animation
    }, 3000); // Le bandeau reste visible pendant 3 secondes
}

