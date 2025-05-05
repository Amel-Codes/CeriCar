<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Proposer un voyage';
?>
<div class="container">
    <h1>Proposer un voyage</h1>

    <?php $form = ActiveForm::begin([
        'id' => 'proposer-form',
        'method' => 'post',
        'action' => ['test/proposer'],
    ]); ?>

    <div class="form-group">
        <?= $form->field($model, 'villeDepart')->textInput([
            'placeholder' => 'Ville de départ',
            'class' => 'form-control',
        ])->label('Ville de départ') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'villeArrivee')->textInput([
            'placeholder' => 'Ville d\'arrivée',
            'class' => 'form-control',
        ])->label('Ville d\'arrivée') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'typevehicule')->textInput(['class' => 'form-control'])->label('Type de véhicule') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'marque')->textInput(['class' => 'form-control'])->label('Marque de véhicule') ?> 
    </div>

    <div class="form-group">
        <?= $form->field($model, 'nbbagage')->textInput(['type' => 'number', 'class' => 'form-control'])->label('Nombre de bagages possible') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'heuredepart')->textInput([
            'type' => 'number',
            'class' => 'form-control',
            'placeholder' => 'Heure de départ (HH)',
            'min' => '0',
            'max' => '23',
        ])->label('Heure de départ') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'contraintes')->textInput(['class' => 'form-control'])->label('Vos contraintes') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'tarif')->textInput(['placeholder' => '...€/km','class' => 'form-control'])->label('Tarif') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'nbplacedispo')->textInput(['type' => 'number', 'class' => 'form-control'])->label('Nombre de places disponibles') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Proposer', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJsFile('@web/js/proposer.js', ['depends' => [yii\web\JqueryAsset::class]]);
?>
