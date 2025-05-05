<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Rechercher un voyage';
?>

<div class="container">
    <h1>Rechercher un voyage</h1>
    <!-- Formulaire de recherche -->

    <?php /*$form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['test/search'], 
        'options' => ['class' => 'search-form', 'id' => 'search-form'],
    ]); */?>

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['test/search'],
        'options' => ['class' => 'search-form', 'id' => 'search-form'],
    ]); ?>

    <div class="form-group">
       <?= $form->field($model, 'villeDepart')->textInput([
         'placeholder' => 'Paris',
         'class' => 'form-control',
         ])->label('Ville de départ') ?>
    </div>

    <div class="form-group">
       <?= $form->field($model, 'villeArrivee')->textInput([
         'placeholder' => 'Marseille',
         'class' => 'form-control',
       ])->label('Ville d\'arrivée') ?>
    </div>

    <div class="form-group">
       <?= $form->field($model, 'nbPersonnes')->textInput([
         'placeholder' => '?',
         'type' => 'number',
         'class' => 'form-control',
       ])->label('Nombre de personnes') ?>
    </div>

    <div class="form-group btn-group">
        <?= Html::submitButton('Rechercher', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    
    <!-- Bandeau de notification -->
    <div id="notification-banner" class="d-none"></div> <!-- d-none pour caché par dft-->

    <!-- Conteneur des résultats -->
    <div id="voyages-container">
      <!--les résultats s'affichent ici-->
    </div>
</div>

<?php
$this->registerJsFile('@web/js/search.js', ['depends' => [yii\web\JqueryAsset::class]]);
?>

