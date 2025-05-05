$(document).on('submit', '#signup-form', function(e) {
    e.preventDefault();
    const data = $(this).serialize(); 
    $.ajax({
        url: 'index.php?r=test/signup', 
        type: 'POST',
        data: data, 
        success: function(response) {
            if (response.notifications) {
                response.notifications.forEach(function(notification) {
                    showNotification(notification.type, notification.message); 
                });
            }
        },
        error: function(xhr, status, error) {
            showNotification('error', 'Une erreur est survenue. Veuillez réessayer plus tard.');
        }
    });
});

function showNotification(type, message) {
    var banner = document.getElementById('notification-banner');
    banner.className = 'alert alert-' + type; 
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

