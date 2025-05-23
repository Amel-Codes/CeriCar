<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Internaute;
use app\models\Voyage;
use app\models\Reservation;
use app\models\Trajet;
use app\models\SearchForm;
use app\models\SignupForm;
use app\models\LoginForm;
use app\models\PropositionForm;
use yii\helpers\Html; 
use yii\web\Request; 
use yii\web\Response;

class TestController extends Controller
{   

/*********************************************Partie 02 (Les infos d'un internaute selon son pseudo)********************************************/
    
    //Lien utilisé pour le test: https://pedago.univ-avignon.fr/~uapv-----/Basic_Yii/web/index.php?r=test/view&pseudo=....
    //Action pour gérer la récupération des infos d'1 utilisateur à partir de son pseudo(Etape 2)
    public function actionView($pseudo)
    {
        // Récupérer l'internaute par son pseudo
        $internaute = Internaute::getUserByIdentifiant($pseudo);

        // Si l'internaute n'existe pas, afficher un message d'erreur
        if (!$internaute) {
            return $this->renderContent("Internaute non trouvé.");
        }
        $voyages = [];
        $reservations = [];
        $voyages = $internaute->voyages; // Tous les voyages proposés par cet internaute
        $reservations = $internaute->reservations; // Toutes les réservations effectuées par cet internaute
        return $this->render('view', [
            'internaute' => $internaute,
            'voyages' => $voyages,
            'reservations' => $reservations,
        ]);
    }

/*********************************************Parties 03 et 04 (Rechercher un voyage)*****************************************/

    //Partie 04
    public function actionSearch()
    {
       $model = new SearchForm();

       if (Yii::$app->request->isAjax) {  // (pour une recherche dynamique)
        
         if ($model->load(Yii::$app->request->post()) && $model->validate()) { //charger les données du formulaire dans model
            $villeDepart = $model->villeDepart;
            $villeArrivee = $model->villeArrivee;
            $nbPersonnes = $model->nbPersonnes;

            $result = Voyage::searchVoyages($villeDepart, $villeArrivee, $nbPersonnes); //effectuer la recherche
            return $this->asJson([  //renvoyer la réponse au format JSON pour ajax
                'voyages' => $result['voyages'],
                'notifications' => $result['notifications'], // Notifications, si besoin
            ]);
          } /*else
            return $this->asJson([  //si validation échouée
                'errors' => $model->errors,
            ]);*/
       }else{
          return $this->render('search', [   //rendre la vue si non requête ajax
            'model' => $model,
          ]);
       }
    }
    
/*********************************************Partie 05 (Se connecter, se déconnecter, s'inscrire et réserver un voyage)*****************************************/
    
    //S'inscrire avec une redirection vers la connexion (ici)si inscription réussie
    public function actionSignup()
    {
        $model = new SignupForm(); 
        $signupResult = null; //pour éviter une erreur en cas d'échec

        if (Yii::$app->request->isAjax) {   
          if ($model->load(Yii::$app->request->post()) && $model->validate()) { 
            $signupResult = $model->signup(); //tenter l'inscription
            if ($signupResult['notifications'][0]['type'] === 'success') {
                $signupResult['redirect'] = 'index.php?r=test/login';
            }
          } else {
            $signupResult = [
                'notifications' => [['type' => 'error','message' => 'La validation a échoué. Veuillez vérifier vos informations.',],],
            ];
          }
          return $this->asJson($signupResult);
        } else{
          return $this->render('signup', [
             'model' => $model,
          ]);
        }
    }

    //Se connecter en utilisant le module de connexion de Yii par mail au lieu de pseudo
    public function actionLogin()
    {
      $model = new LoginForm();
      if ($model->load(Yii::$app->request->post()) && $model->login()) {
        return $this->goBack(); // Rediriger l'utilisateur après la cnx vers la page d'accueil (search)
      }
      return $this->render('login', ['model' => $model,]);
    }

    // Les réservations d'un internaute connecté
    public function actionReservations()
    {
       //vérifier si l'utilisateur est connecté
       if (Yii::$app->user->isGuest) {
         return $this->redirect(['test/login']); //redirige vers la page de connexion si non connecté
       }
       
       $user = Yii::$app->user->identity; //récupérer l'utilisateur connecté
       if ($user === null) {
        throw new \yii\web\ForbiddenHttpException('Utilisateur non trouvé.');
       }

       $reservations = $user->reservations;

       return $this->render('reservations', [
        'reservations' => $reservations,
       ]);
    }
     
     // Le profil d'un utilisateur connecté
    public function actionProfile()
    {
      if (Yii::$app->user->isGuest) {
        return $this->redirect(['test/login']);
      }

      $user = Yii::$app->user->identity; //récupérer l'utilisateur connecté

      if (!$user) {
        throw new \yii\web\NotFoundHttpException("Utilisateur introuvable.");
      }

      return $this->render('profile', [
        'user' => $user,
      ]);
    }
     
    //les voyages proposés par un utilisateur connecté
    public function actionPropositions()
    {
       if (Yii::$app->user->isGuest) {
        return $this->redirect(['test/login']);
       }

       $user = Yii::$app->user->identity; //récupérer l'utilisateur connecté
       $propositions = $user->voyages;

       return $this->render('propositions', [
        'propositions' => $propositions,
       ]);
    }   
    
    //action de déconnexion (du modèle de connexion/déconnexion de Yii)
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }    

    // Reserver un voyage si connecté avec ajax avec la search view, redirection vers mes reservations si réussie (dans la requete)
    public function actionReserver()
    {
         if(Yii::$app->user->isGuest) {
           return $this->asJson([
               'notifications' => [['type' => 'error', 'message' => 'Vous devez être connecté pour réserver.']],
           ]);
         }

         //récupérer les données envoyées par AJAX
         $voyage_id = Yii::$app->request->post('voyage_id');
         $nbplaceresa = Yii::$app->request->post('nbplaceresa');

         $reservation = new Reservation();
         $response = $reservation->reserver($voyage_id, $nbplaceresa);

         return $this->asJson($response);
    }
     

/**************************************************************Partie 06 (proposition d'un vyage)****************************************************************/

    public function actionProposer() 
    {
        $model = new PropositionForm();

        if (Yii::$app->request->isAjax) {
          if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Vérifier si l'utilisateur est connecté
            if (Yii::$app->user->isGuest) {
                return $this->asJson(['notification' => [ ['type' => 'error', 'message' => 'Vous ne pouvez pas proposer de voyage avant de vous connecter.']]]);
            }
            
            $userId = Yii::$app->user->id; //Récupérer l'id de l'intrnaute connecté

            $notification = $model->proposer($userId);

            return $this->asJson($notification);
          } else {
            // Si la validation échoue
            return $this->asJson(['notification' => [ ['type' => 'error', 'message' => 'La validation du formulaire a échoué.']]]);
          }
       } else {
          return $this->render('proposer', ['model' => $model]);
       }
    }

}

?>
