<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

//j'ai utilisé login.php de views/site, je l'ai mise à jour

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Connexion';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Veuillez remplir les champs suivants pour vous connecter :</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-form-label'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'mail')->textInput(['autofocus' => true, 'type' => 'email']) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Entrez votre mot de passe']) ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div>{error}</div>",
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Se connecter', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <div style="color:#999; margin-top: 10px;">
                Vous pouvez vous connecter avec vos identifiants personnels.<br>
                Si vous avez oublié vos informations, veuillez contacter l'administrateur.
            </div>

        </div>
    </div>
</div>
             
