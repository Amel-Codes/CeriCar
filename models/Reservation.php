<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Reservation extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.reservation'; // Nom de la table
    }

    // Relation avec le voyage : Chaque réservation appartient à un voyage
    public function getInfosvoyage()
    {
        return $this->hasOne(Voyage::class, ['id' => 'voyage']);
    }

    // Relation avec le voyageur (internaute) : Chaque réservation est faite par un voyageur
    public function getInfosvoyageur()
    {
        return $this->hasOne(Internaute::class, ['id' => 'voyageur']);
    }
    // Méthode pour récupérer toutes les réservations d'un voyage
    public static function getReservationByVoyage($voyageId)
    {
        return self::find()->where(['voyage' => $voyageId])->all(); // Retourne toutes les réservations pour ce voyage
    }

    public function rules()
    {
        return [
            [['voyage', 'voyageur', 'nbplaceresa'], 'required'],
            [['voyage', 'voyageur'], 'integer'],
            [['nbplaceresa'], 'integer', 'min' => 1],
        ];
    }

    //Méthode pour gérer la réservation
    public function reserver($voyage_id, $nbplaceresa)
    {
        // Récupérer le voyage
        $voyage = Voyage::findOne($voyage_id);
        if (!$voyage) {
            return ['notifications' => [['type' => 'error', 'message' => 'Aucun voyage trouvé.' ]]];
        }

        // Vérifier le nombre de places déjà réservées pour ce voyage
        $reservations = $voyage->reservations;
        $NbPlacesPrises = 0; // Total des places déjà réservées
        foreach ($reservations as $reservation) {
            $NbPlacesPrises += $reservation->nbplaceresa;
        }

        // Vérifier qu'il y a assez de places disponibles
        if ($nbplaceresa > ($voyage->nbplacedispo - $NbPlacesPrises)) {
            Yii::error('Validation échouée : ' . json_encode($this->errors));
            return ['notifications' => [['type' => 'warning', 'message' => 'Nombre de places non disponible' ]]];
        }

        // Enregistrer la réservation
        $this->voyage = $voyage_id;
        $this->voyageur = Yii::$app->user->id;
        $this->nbplaceresa = $nbplaceresa;

        if ($this->save()) {
             return ['notifications' => [['type' => 'success', 'message' => 'Réservation Réussie' ]]];
        }
        return ['notifications' => [['type' => 'error', 'message' => 'Une erreur est survenue lors de la réservation.' ]]];
    }
}

?>
