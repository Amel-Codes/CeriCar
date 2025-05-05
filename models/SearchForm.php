<?php

namespace app\models;

use yii\base\Model;
use app\models\Trajet;
use app\models\Internaute;
use app\models\Voyage;

class SearchForm extends Model
{
    public $villeDepart;
    public $villeArrivee;
    public $nbPersonnes;

    /**
     * Définir les règles de validation du formulaire
     */
     public function rules()
     {
       return [
        [['villeDepart', 'villeArrivee', 'nbPersonnes'], 'required'],
        [['nbPersonnes'], 'integer'],
        ];
     }

}
