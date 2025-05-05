$(document).on('submit', '#proposer-form', function(e) {
    e.preventDefault();
    const data = $(this).serialize();

    $.ajax({
        url: 'index.php?r=test/proposer', 
        type: 'POST',
        data: data,
        success: function(response) {
          // Vérification si la réponse contient une notification
          if (response.notification[0]) {
             notification = response.notification[0];
             showNotification(notification.type, notification.message);
             if (notification.type === 'success') {
                window.location.href = 'index.php?r=test/propositions'; //rediriger en cas de succès
             } else if (notification.type === 'error' && notification.message === 'Vous ne pouvez pas proposer de voyage avant de vous connecter.') {
               setTimeout(function() {
                  window.location.href = 'index.php?r=test/login';  //rediriger vers la page de connexion si non connecté
               }, 2000);
             }
          } else {
             showNotification('error', 'Une erreur inattendue est survenue.');
          }
       },
       error: function() {
            showNotification('error', 'Une erreur est survenue lors de la soumission du formulaire.');
       }
    });
});


// Fonction pour afficher les notifications
function showNotification(type, message) {
    const banner = document.getElementById('notification-banner');
    banner.className = `alert alert-${type}`;
    banner.textContent = message;

    banner.style.display = 'block';
    banner.style.opacity = 0;
    setTimeout(() => {
        banner.style.opacity = 1;
        banner.style.transform = 'translateY(0)';
    }, 10);

    setTimeout(() => {
        banner.style.opacity = 0;
        banner.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            banner.style.display = 'none';
        }, 500);
    }, 3000);
}

