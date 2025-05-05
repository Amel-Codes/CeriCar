<?php

namespace app\models;

use yii\base\Model;
use app\models\Trajet;
use app\models\Internaute;
use app\models\Voyage;

class PropositionForm extends Model
{
    public $villeDepart;
    public $villeArrivee;
    public $typevehicule;
    public $marque;
    public $nbbagage;
    public $heuredepart; 
    public $contraintes;
    public $tarif;
    public $nbplacedispo;

    //Définir les règles de validation du formulaire
     public function rules()
     {
       return [
        [['villeDepart', 'villeArrivee', 'typevehicule', 'marque', 'nbbagage', 'heuredepart', 'tarif', 'nbplacedispo'], 'required'],
        [['villeDepart', 'villeArrivee'], 'string'],
        [['typevehicule', 'marque', 'contraintes'], 'string'],
        [['tarif'], 'number', 'min' => 0, 'tooSmall' => 'Le tarif ne peut pas être inférieur à 0'],
        [['nbbagage', 'nbplacedispo'], 'integer'],
        [['heuredepart'], 'integer', 'min' => 0, 'max' => 23, 'tooSmall' => 'L\'heure de départ ne peut pas être inférieure à 00', 'tooBig' => 'L\'heure de départ ne peut pas être supérieure à 23'],
       ];
     }

    // Transforme chaque mot en miniscules avec la première lettre en majuscule (s'adapte avec le format en bdd)
    public static function formatCityName($city)
    {
      return mb_convert_case(mb_strtolower($city), MB_CASE_TITLE, "UTF-8");
    }
 
    //Méthode pour proposer un voyage
    public function proposer($conducteurId)
    {
        $this->villeDepart = self::formatCityName($this->villeDepart);
        $this->villeArrivee = self::formatCityName($this->villeArrivee);
        //recherche du trajet à partir des villes de départ et d'arrivée
        $trajet = Trajet::getTrajet($this->villeDepart, $this->villeArrivee);
        if (!$trajet) {
            // Si le trajet n'existe pas, renvoyer une notification d'erreur
            return [
                'notification' => [['type' => 'error','message' => 'Le trajet entre ' . $this->villeDepart . ' et ' . $this->villeArrivee . ' n\'existe pas.',]]
            ];
        }

        //recherche de l'internaute (conducteur) connecté
        $conducteur = Internaute::findOne($conducteurId);
        if (!$conducteur) {
           return [
                'notification' => [['type' => 'error', 'message' => 'Conducteur non trouvé.', ]]
           ];
        }

        //vérification du permis 
        if (empty($conducteur->permis)) {
           
           return [
                'notification' => [[ 'type' => 'error', 'message' => 'Vous devez posséder un permis pour proposer un voyage.',] ]
           ];
        }

        // Création du voyage
        $voyage = new Voyage();
        $voyage->conducteur = $conducteurId;
        $voyage->trajet = $trajet->id;
        $voyage->typevehicule = $this->typevehicule;
        $voyage->marque = $this->marque;
        $voyage->nbbagage = $this->nbbagage;
        $voyage->heuredepart = $this->heuredepart; // L'heure de départ comme entier
        $voyage->contraintes = $this->contraintes;
        $voyage->tarif = $this->tarif;
        $voyage->nbplacedispo = $this->nbplacedispo;

        if ($voyage->validate() && $voyage->save()) {
            return [
                'notification' => [[ 'type' => 'success', 'message' => 'Votre voyage a été proposé avec succès.',] ]
            ];
        } else {
            return [
                'notification' => [[ 'type' => 'error','message' => 'Une erreur est survenue lors de la proposition du voyage.',]]
            ];
        }
    }
}

