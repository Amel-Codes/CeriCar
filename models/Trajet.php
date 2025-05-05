<?php
namespace app\models;

use yii\db\ActiveRecord;

class Trajet extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.trajet';
    }

    // Relation avec les voyages : Un trajet a plusieurs voyages
    public function getVoyages()
    {
        return $this->hasMany(Voyage::class, ['trajet' => 'id']);
    }

    // Méthode pour récupérer un trajet à partir de deux chaînes de caractères : ville de départ et ville d'arrivée
    public static function getTrajet($villeDepart, $villeArrivee)
    {
      // Vérification que les villes ne sont pas vides
      if (empty($villeDepart) || empty($villeArrivee)) {
        return null; // Retourner null si les valeurs sont invalides
      }

      // Recherche du trajet dans la base de données
      return self::findOne([
        'depart' => $villeDepart,
        'arrivee' => $villeArrivee
      ]);
    }

}

?>
