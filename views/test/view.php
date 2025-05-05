<?php
use yii\helpers\Html;

/** @var $internaute app\models\Internaute */
/** @var $voyages array */
/** @var $reservations array */

// Afficher les informations de l'internaute
?>

<h1>Informations sur l'internaute</h1>

<p><strong>Nom :</strong> <?= Html::encode($internaute->nom) ?></p>
<p><strong>Prénom :</strong> <?= Html::encode($internaute->prenom) ?></p>
<p><strong>E-mail :</strong> <?= Html::encode($internaute->mail) ?></p>
<?php if (!empty($internaute->photo)): ?>
    <p><strong>Photo de profil:</strong></p>
    <img src="<?= Html::encode($internaute->photo) ?>" alt="Photo de <?= Html::encode($internaute->pseudo) ?>" width="150">
<?php else: ?>
    <p><strong>Pas de photo disponible.</strong></p>
<?php endif; ?>

<!-- Vérification si l'internaute a des voyages mais pas de permis -->
<?php if (!empty($voyages) && empty($internaute->permis)): ?>
    <p><strong>   --> Note :</strong> Cet internaute propose des voyages, mais n'a pas de permis.</p>   
<?php endif; ?>

<?php if (!empty($voyages)): ?>
    <h2>Voyages proposés</h2>
    <?php foreach ($voyages as $voyage): ?>
        <div>
            <p><strong>Trajet :</strong> <?= Html::encode($voyage->infostrajet->depart . ' - ' . $voyage->infostrajet->arrivee) ?></p>
            <p><strong>Tarif :</strong> <?= Html::encode($voyage->tarif) ?> €/km</p>
            <p><strong>Places disponibles :</strong> <?= Html::encode($voyage->nbplacedispo) ?></p>
            <p><strong>Nombre de bagages autorisé :</strong> <?= Html::encode($voyage->nbbagage) ?></p>
            <p><strong>Départ à :</strong> <?= Html::encode($voyage->heuredepart) ?>h</p>
            <p><strong>Infos sur le véhicule: </strong> <?= Html::encode($voyage->typevehicule)?> <?= Html::encode($voyage->marque) ?></p>
            <p><strong>Contraintes :</strong> <?= Html::encode($voyage->contraintes) ?></p>

            <?php //Ici on peut utiliser getReservationByVoyage($voyage) après une instanciation de la classe reservation
                    if (!empty($voyage->reservations)): ?>
                <p><strong>Réservations de ce voyage:</strong></p>
                <ul>
                    <?php foreach ($voyage->reservations as $reservation): ?>
                        <li>Réservé par <?= Html::encode($reservation->infosvoyageur->pseudo) ?>, places réservées : <?= Html::encode($reservation->nbplaceresa) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p><strong>Pas encore réservé (0 réservations).</strong></p>
            <?php endif; ?>            
        </div>
    <p>----------------------------------------------------------------------------------</p>
    <?php endforeach; ?>
<?php endif; ?>


<?php if (!empty($reservations)): ?>
    <h2>Réservations effectuées</h2>
    <?php foreach ($reservations as $reservation): ?>
        <div>
            <p><strong>Trajet :</strong> <?= Html::encode($reservation->infosvoyage->infostrajet->depart . ' - ' . $reservation->infosvoyage->infostrajet->arrivee) ?></p>
            <p><strong>Nombre de places réservées :</strong> <?= Html::encode($reservation->nbplaceresa) ?></p>
            <p><strong>Conducteur :</strong> <?= Html::encode($reservation->infosvoyage->infosconducteur->pseudo) ?></p>
        </div>
     <p>----------------------------------------------------------------------------------</p>
    <?php endforeach; ?>
<?php endif; ?>

