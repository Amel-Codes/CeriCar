<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="container">
    <h1>Inscription</h1>
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['test/signup'],
        'options' => ['class' => 'signup-form', 'id' => 'signup-form', 'enctype' => 'multipart/form-data']
    ]); ?>
    <div class="form-group">
        <?= $form->field($model, 'pseudo')->textInput([
            'placeholder' => 'Votre pseudo',
            'class' => 'form-control',
        ])->label('Pseudo') ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'mail')->input('email', [
            'placeholder' => 'exemple@domaine.com',
            'class' => 'form-control',
        ])->label('Email') ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'pass')->passwordInput([
            'placeholder' => 'Mot de passe',
            'class' => 'form-control',
        ])->label('Mot de passe') ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'nom')->textInput([
            'placeholder' => 'Votre nom',
            'class' => 'form-control',
        ])->label('Nom') ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'prenom')->textInput([
            'placeholder' => 'Votre prénom',
            'class' => 'form-control',
        ])->label('Prénom') ?>  </div>
    <div class="form-group">
        <?= $form->field($model, 'photo')->textInput([
            'placeholder' => 'url',
            'class' => 'form-control',
        ])->label('Photo de profil') ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'permis')->textInput([
            'type' => 'number',
            'placeholder' => 'Numéro de permis',
            'class' => 'form-control',
        ])->label('Numéro de permis') ?>
    </div>
    <div class="form-group btn-group">
        <?= Html::submitButton('S\'inscrire', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div id="notification-banner" class="d-none"></div> <!-- Caché par défaut -->
</div>
<?php
$this->registerJsFile('@web/js/signup.js', ['depends' => [yii\web\JqueryAsset::class]]);
?>
