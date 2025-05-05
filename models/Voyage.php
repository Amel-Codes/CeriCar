<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Voyage extends ActiveRecord
{
    public static function tableName()
    {
        return 'fredouil.voyage';
    }
    //chaque voyage a un champ trajet qui fait référence à l'id d'un trajet.
    public function getInfostrajet()
    {
        return $this->hasOne(Trajet::class, ['id' => 'trajet']);
    }
    
    //chaque voyage a un champ conducteur qui fait référence à l'id d'un internaute conducteur.
    public function getInfosconducteur()
    {
        return $this->hasOne(Internaute::class, ['id' => 'conducteur']);
    }
    
    //chaque voyage a plusieurs réservations tq dans le champs voyage de Reservation, y'a l'id du voyge associé
    public function getReservations()
    {
        return $this->hasMany(Reservation::class, ['voyage' => 'id']);
    }
    // Méthode pour récupérer tous les voyages correspondant à un trajet
    public static function getVoyagesByTrajet($trajetId)
    {
        return self::find()->where(['trajet' => $trajetId])->all(); // Retourne tous les voyages pour ce trajet
    }

    /* Partie 03*/    
    // Transforme chaque mot en miniscules avec la première lettre en majuscule (s'adapte avec le format en bdd)
    public static function formatCityName($city)
    {
      return mb_convert_case(mb_strtolower($city), MB_CASE_TITLE, "UTF-8");
    }

    // Fonction qui gère la recherche de voyages:elle retourne les voyages trouvés et les notifications /partie 04/
    public static function searchVoyages($villeDepart, $villeArrivee, $nbPersonnes)
    { 
       //Normaliser les noms des villes
       $villeDepart = self::formatCityName($villeDepart);
       $villeArrivee = self::formatCityName($villeArrivee);
       $voyages = [];
       $notifications = []; // Stocker les messages de notification

       $trajet = Trajet::getTrajet($villeDepart, $villeArrivee);
       if (!$trajet) {  // Vérifier si les villes existent dans la base de données
         $notifications[] = ['type' => 'error', 'message' => 'Les villes de départ ou d\'arrivée n\'existent pas.'];
         return ['voyages' => $voyages, 'notifications' => $notifications];
       }

       $voyagesList = self::getVoyagesByTrajet($trajet->id);
       if (empty($voyagesList)) {
        $notifications[] = ['type' => 'warning', 'message' => 'Aucun voyage trouvé pour ce trajet.'];
       } else {
        $notifications[] = ['type' => 'success', 'message' => 'Recherche terminée.'];
       }

       foreach ($voyagesList as $voyage) {
         $reservations = Reservation::getReservationByVoyage($voyage->id);
         $NbPlacesPrises = 0; // Calculer le nombre total de places prises
         foreach ($reservations as $reservation) 
            $NbPlacesPrises += $reservation->nbplaceresa;
         $placesRestantes = max(0, $voyage->nbplacedispo-$NbPlacesPrises);
         $status = $placesRestantes > $nbPersonnes ? 'Disponible' : 'Complet';
         $voyages[] = ['id' => $voyage->id,
                       'typevehicule' => $voyage->typevehicule,
                       'marque' => $voyage->marque,
                       'nbbagage' => $voyage->nbbagage,
                       'heuredepart' => $voyage->heuredepart,
                       'contraintes' => $voyage->contraintes,
                       'trajet' => ['villeDepart' => $voyage->infostrajet->depart,'villeArrivee' => $voyage->infostrajet->arrivee,],
                       'conducteur' => ['nom' => $voyage->infosconducteur->nom,'prenom' => $voyage->infosconducteur->prenom,'email' => $voyage->infosconducteur->mail,],
                       'placesRestantes' => $placesRestantes,
                       'status' => $status,
                       'coutTotal' => $voyage->tarif * $placesRestantes];
       }
       return ['voyages' => $voyages, 'notifications' => $notifications];
    }

}

?>
