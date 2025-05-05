$(document).on('submit', '#search-form', function(e) {
    e.preventDefault();
    const data = $(this).serialize(); //conversion en ".....&....."
    $.ajax({
        url: 'index.php?r=test/search',
        type: 'POST',
        data: data,
        success: function(response) {
            handleAjaxResponse(response);
        },
        error: function() {
            showNotification('error', 'Une erreur est survenue lors de la recherche.');
        }
    });
});

function handleAjaxResponse(response) {
    if (response.notifications) {
        response.notifications.forEach(function(notification) {
            showNotification(notification.type, notification.message);
        });
    }
    if (response.voyages) {
        const voyagesContainer = $('#voyages-container');
        voyagesContainer.empty(); //je vide le contenu précédent
        if (response.voyages.length === 0) {
            /*if (response.notifications && response.notifications.some(n => n.type === 'error')) {
                voyagesContainer.html('<p><strong>Les informations saisies sont erronées. Veuillez vérifier vos critères.</strong></p>');
            }
            if (response.notifications && response.notifications.some(n => n.type === 'warning')) {
                voyagesContainer.html('<p><strong>Aucun voyage disponible.</strong></p>');
            }*/
        } else {
            voyagesContainer.html(renderVoyages(response.voyages)); //afficher les voyages avec les boutons de réservation
        }
    }
}

function renderVoyages(voyages) {
    return voyages.map(function(voyage) {
        //détermine si le voyage est complet
        const isComplete = voyage.placesRestantes === 0;
        
        //classe CSS différente si le voyage est complet
        const completeClass = isComplete ? 'voyage-complet' : '';

        return `
            <div class="voyage-card ${completeClass}">
                <div class="voyage-header">
                    <h3>${voyage.conducteur.prenom} ${voyage.conducteur.nom}</h3>
                    <p class="voyage-email">${voyage.conducteur.email}</p>
                </div>
                <div class="voyage-info">
                    <div><strong>Type de véhicule:</strong> ${voyage.typevehicule}</div>
                    <div><strong>Marque:</strong> ${voyage.marque}</div>
                    <div><strong>Nombre de bagages:</strong> ${voyage.nbbagage}</div>
                    <div><strong>Heure de départ:</strong> ${voyage.heuredepart}</div>
                    <div><strong>Contraintes:</strong> ${voyage.contraintes}</div>
                    ${isComplete ? '' : `<p><strong>Places restantes:</strong> ${voyage.placesRestantes}</p>`}
                    ${isComplete ? '' : `<p><strong>Coût total:</strong> ${voyage.coutTotal}€ ( ${voyage.placesRestantes} places )</p>`}
                </div>
                ${isComplete ? `<p class="voyage-complet-message">Ce voyage est complet</p>` : `
                    <!-- Si pas complet,affiche un formulaire pour demande de réservation-->
                    <div class="reservation">
                        <label for="places">Nombre de places :</label>
                        <input type="number" name="nbplaceresa" value="1" required>
                        <button class="btn btn-primary reservation-button" data-id="${voyage.id}" ">Demander une réservation</button>
                    </div>
                `}
            </div>
            <hr>
        `;
    }).join('');
}

//max="${voyage.placesRestantes}"

function showNotification(type, message) {
    const banner = document.getElementById('notification-banner');
    banner.className = `alert alert-${type}`; //ajoute la classe correspondante au type de notif
    banner.textContent = message;

    //afficher bandeau avec 1 transition douce
    banner.style.display = 'block';
    banner.style.opacity = 0; //démarre avec opacité nulle(invisible)
    setTimeout(() => {
        banner.style.opacity = 1; //apparaître le bandeau avec 1 effet de fondu
        banner.style.transform = 'translateY(0)'; //descend le bandeau
    }, 10); //délai très court pour que le JS applique l'opacity à 0 avant la transition

    setTimeout(() => {
        banner.style.opacity = 0; //disparaître le bandeau avec un fondu
        banner.style.transform = 'translateY(-10px)'; //le remonter légèrement avant de le cacher
        setTimeout(() => {
            banner.style.display = 'none';
        }, 500); //durée de l'animation)
    }, 1000); //bandeau visible pendant 1s
}



//lorsque l'utilisateur clique sur un bouton de réservation
$(document).on('click', '.reservation-button', function(e) {
    e.preventDefault();

    var voyageId = $(this).data('id');
    var nbPlaces = $(this).prev('input').val(); 

    $.ajax({
        url: 'index.php?r=test/reserver', 
        type: 'POST',
        data: {
            voyage_id: voyageId,
            nbplaceresa: nbPlaces
        },
        success: function(response) {
            if (response.notifications) {
                response.notifications.forEach(function(notification) {
                    showNotification(notification.type, notification.message);
                });
            }
            if (response.notifications && response.notifications[0].type === 'success') {
               setTimeout(function() {
                    window.location.href = 'index.php?r=test/reservations'; //response.redirectUrl;
               }, 1000); //attend 1s avant la redirection
            }
        },
        error: function() {
            showNotification('error', 'Une erreur s\'est produite lors de la demande de réservation.');
        }
    });
});

