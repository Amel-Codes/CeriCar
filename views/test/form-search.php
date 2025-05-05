<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $this yii\web\View */

$this->title = 'Rechercher un voyage';
?>

<div class="voyage-search-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['method' => 'post', 'action' => ['test/search']]); ?>

    <?= $form->field(new \app\models\Trajet(), 'depart')
        ->textInput(['name' => 'villeDepart', 'placeholder' => 'Ville de départ', 'required' => true])
        ->label('Ville de départ') ?>

    <?= $form->field(new \app\models\Trajet(), 'arrivee')
        ->textInput(['name' => 'villeArrivee', 'placeholder' => 'Ville d\'arrivée', 'required' => true])
        ->label('Ville d\'arrivée') ?>

    <?= Html::label('Nombre de voyageurs', 'nbPersonnes') ?>
    <?= Html::input('number', 'nbPersonnes', '', [
        'class' => 'form-control',
        'min' => 1,
        'required' => true,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Rechercher', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

