<?php
/** @var yii\web\View $this */
/** @var app\models\Voyage[] $propositions */

use yii\helpers\Html;

$this->title = 'Mes Propositions';
?>

<h1 class="page-title"><?= Html::encode($this->title) ?></h1>

<?php if (!empty($propositions)): ?>
    <h2 class="section-title">Voyages proposés</h2>
    <?php foreach ($propositions as $voyage): ?>
        <div class="voyage-card">
            <h3 class="voyage-title">Trajet : <?= Html::encode($voyage->infostrajet->depart . ' - ' . $voyage->infostrajet->arrivee) ?></h3>
            <p><strong>Tarif :</strong> <?= Html::encode($voyage->tarif) ?> €/km</p>
            <p><strong>Places disponibles :</strong> <?= Html::encode($voyage->nbplacedispo) ?></p>
            <p><strong>Bagages autorisés :</strong> <?= Html::encode($voyage->nbbagage) ?></p>
            <p><strong>Départ à :</strong> <?= Html::encode($voyage->heuredepart) ?>h</p>
            <p><strong>Véhicule :</strong> <?= Html::encode($voyage->typevehicule) ?> <?= Html::encode($voyage->marque) ?></p>
            <p><strong>Contraintes :</strong> <?= !empty($voyage->contraintes) ? Html::encode($voyage->contraintes) : 'Aucune' ?></p>

            <?php if (!empty($voyage->reservations)): ?>
                <div class="reservations-section">
                    <p><strong>Réservations pour ce voyage :</strong></p>
                    <ul class="reservation-list">
                        <?php foreach ($voyage->reservations as $reservation): ?>
                            <li>
                                <span class="reservation-user"><?= Html::encode($reservation->infosvoyageur->pseudo) ?></span> - 
                                <span class="reservation-places">Places réservées : <?= Html::encode($reservation->nbplaceresa) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <p><em>Ce voyage n'a pas encore été réservé.</em></p>
            <?php endif; ?>
        </div>
        <hr class="voyage-divider">
    <?php endforeach; ?>
<?php else: ?>
        <div class="no-propositions">
            <p>Vous n'avez proposé aucun voyage pour le moment.</p>
            <p><a href="<?= \yii\helpers\Url::to(['test/proposer']) ?>" class="btn btn-primary">Proposer un voyage</a></p>
        </div>
<?php endif; ?>












<style>
.page-title {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
}

.section-title {
    font-size: 22px;
    margin-top: 30px;
    margin-bottom: 15px;
    color: #333;
}

.voyage-card {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.voyage-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
}

.reservations-section {
    background-color: #e9ecef;
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
}

.reservation-list {
    margin: 10px 0;
    padding-left: 20px;
}

.reservation-list li {
    margin-bottom: 5px;
}

.voyage-divider {
    border: 0;
    height: 1px;
    background: #ddd;
    margin: 20px 0;
}

.no-propositions {
    text-align: center;
    font-size: 16px;
    color: #888;
}

</style>
