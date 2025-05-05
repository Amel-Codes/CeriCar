<?php
/** @var yii\web\View $this */
/** @var app\models\Internaute $user */

use yii\helpers\Html;

$this->title = 'Mon Profil';
?>

<div class="profile-container">
    <h1 class="mb-4">Mon Profil</h1>
    <div class="profile-info">
        <p><strong>Nom d'utilisateur :</strong> <?= Html::encode($user->pseudo) ?></p>
    </div>
    <div class="profile-info">
        <p><strong>Nom et Prénom :</strong> <?= Html::encode($user->nom) . ' ' . Html::encode($user->prenom) ?></p>
    </div>
    <div class="profile-info">
        <p><strong>Email :</strong> <?= Html::encode($user->mail) ?></p>
    </div>
    <?php if (!empty($user->photo)): ?>
        <div class="profile-photo">
            <p><strong>Photo de profil :</strong></p>
            <img src="<?= Html::encode($user->photo) ?>" alt="Photo de <?= Html::encode($user->pseudo) ?>" class="img-fluid rounded-circle" width="150">
        </div>
    <?php else: ?>
        <div class="profile-photo">
            <p><strong>Pas de photo disponible.</strong></p>
        </div>
    <?php endif; ?>
    <div class="profile-permit">
        <?php if (!empty($user->permis)): ?>
            <p><strong>Je suis conducteur.</strong></p>
        <?php else: ?>
            <p><strong>Je ne peux pas covoiturer.</strong></p>
        <?php endif; ?>
    </div>

    <div class="profile-actions">
        <?= Html::a('Voir mes réservations', ['test/reservations'], ['class' => 'btn btn-primary me-2']) ?>
        <?= Html::a('Voir mes voyages proposés', ['test/propositions'], ['class' => 'btn btn-primary me-2']) ?>
    </div>
</div>













<style>
    .profile-container {
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .profile-info {
        margin-bottom: 15px;
    }
    .profile-photo {
        margin-bottom: 20px;
    }
    .profile-actions {
        margin-top: 20px;
    }
</style>

