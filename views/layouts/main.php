
<?php
/** @var yii\web\View $this */
/** @var string $content */
use app\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    //<meta name="csrf-token" content="<?= Yii::$app->request->getCsrfToken() ?>">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">

<?php $this->beginBody() ?>

<header id="header">
    <?php
    //détection si l'utilisateur est connecté
    $isGuest = Yii::$app->user->isGuest;
    $user = !$isGuest ? Yii::$app->user->identity : null;
    //récupération de l'image de profil si disponible (sinon l'icône par défaut)
    $profileImageUrl = !$isGuest && $user->photo ? $user->photo : Yii::getAlias('@web') . '/images/Icone.jpg';
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= \yii\helpers\Url::to(['test/search']) ?>">CeriCar</a>

            <!-- bouton pour afficher ou masquer les élts du menu lorsque l'écran est trop petit -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!--contenu de la navbar qui peut être masqué/affiché -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= \yii\helpers\Url::to(['test/search']) ?>">Rechercher un voyage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= \yii\helpers\Url::to(['test/proposer']) ?>">Proposer un voyage</a>
                    </li>
                    
                    <!-- Dropdown menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= $profileImageUrl ?>" class="rounded-circle" alt="Profil" style="width:30px; height:30px; object-fit:cover;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <?php if ($isGuest): ?>
                                <li><a class="dropdown-item" href="<?= \yii\helpers\Url::to(['test/login']) ?>">Se connecter</a></li>
                                <li><a class="dropdown-item" href="<?= \yii\helpers\Url::to(['test/signup']) ?>">S'inscrire</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="<?= \yii\helpers\Url::to(['test/reservations']) ?>">Mes réservations</a></li>
                                <li><a class="dropdown-item" href="<?= \yii\helpers\Url::to(['test/propositions']) ?>">Mes propositions</a></li>
                                <li><a class="dropdown-item" href="<?= \yii\helpers\Url::to(['test/profile']) ?>">Mon profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= \yii\helpers\Url::to(['test/logout']) ?>" data-method="post">Déconnexion</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Bandeau de notification global -->
<div id="notification-banner" class="alert d-none" role="alert"></div>

<!-- Contenu principal -->
<div id="main-content" class="container mt-5">
    <?= $content ?> 
</div>

<footer class="mt-auto bg-light py-4">
    <div class="container text-center">
        <p>© 2024 CeriCar. Tous droits réservés.</p>
    </div>
</footer>

<?php $this->registerJsFile('@web/js/search.js', ['depends' => [yii\web\JqueryAsset::class]]); ?>
<?php $this->registerJsFile('@web/js/signup.js', ['depends' => [yii\web\JqueryAsset::class]]); ?>
<?php $this->registerJsFile('@web/js/proposer.js', ['depends' => [yii\web\JqueryAsset::class]]); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


