<?php
/** @var yii\web\View $this */
/** @var app\models\Reservation[] $reservations */

use yii\helpers\Html;

$this->title = 'Mes Réservations';
?>
<div class="reservations-page">
    <h1 class="page-title"><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($reservations)): ?>
        <h2 class="section-title">Réservations effectuées</h2>
        <div class="reservations-list">
            <?php foreach ($reservations as $reservation): ?>
                <div class="reservation-item">
                    <h3 class="trajet-title">
                        Trajet : <?= Html::encode($reservation->infosvoyage->infostrajet->depart . ' - ' . $reservation->infosvoyage->infostrajet->arrivee) ?>
                    </h3>
                    <p><strong>Conducteur :</strong> <?= Html::encode($reservation->infosvoyage->infosconducteur->nom) . ' ' . Html::encode($reservation->infosvoyage->infosconducteur->prenom) ?><br>
                    <strong>Nombre de places réservées :</strong> <?= Html::encode($reservation->nbplaceresa ?? 'Non spécifié') ?><br>
                    <strong>Prix :</strong> <?= Html::encode($reservation->infosvoyage->tarif*$reservation->nbplaceresa ?? 'Non spécifié') ?> €</p>
                    
                </div>
                <hr class="reservation-divider">
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-reservations">
            <p>Vous n'avez effectué aucune réservation pour le moment.</p>
            <p><a href="<?= \yii\helpers\Url::to(['test/search']) ?>" class="btn btn-primary">Rechercher un voyage & réserver </a></p>
        </div>
    <?php endif; ?>
</div>
















<style>
    .reservations-page {
        font-family: Arial, sans-serif;
        line-height: 1.6;
    }
    .page-title {
        text-align: center;
        margin-bottom: 20px;
        font-size: 2em;
        color: #333;
    }
    .section-title {
        margin-top: 30px;
        font-size: 1.5em;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        color: #007bff;
    }
    .reservations-list {
        margin-top: 20px;
    }
    .reservation-item {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
    }
    .trajet-title {
        font-size: 1.2em;
        color: #555;
    }
    .reservation-divider {
        margin: 20px 0;
        border: none;
        border-top: 1px solid #ccc;
    }
    .no-reservations {
        text-align: center;
        margin-top: 50px;
    }
    .btn-primary {
        display: inline-block;
        text-decoration: none;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border-radius: 5px;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

