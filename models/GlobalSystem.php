<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 *
 *
 * @property-read User|null $user
 *
 */
class GlobalSystem extends Model
{
   private Conducteur [] Conducteurs;
   private Trajet [] Trajets;
   private Voyageurs [] Voyageurs;
   private Voyage [] Voyages;
   private Reservation [] Reservations;

  //Récupérer l'ensemble des voyages liés à un trajet donné
   Voyage getVoyagesByTrajet(int trajet){
       return voayges;  
   }

}
