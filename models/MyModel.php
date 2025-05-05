<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * MyModel is the model behind the dropdownlist.
 *
 * @property-read User|null $user
 *
 */
class MyModel extends Model
{
    public $Fruits;

    //Constructeur pour initialiser la propriété tableau
    public function __construct($config = []){
      //Appel au contructeur parent
      parent::__construct($config);
      $this->Fruits = [
           '1' =>[
                   'id' => '1',
                   'fruit' => 'Mangue'
                 ],
           '2' =>[
                   'id' => '2',
                   'fruit' => 'Myrtilles'
                 ],
           '3' =>[
                   'id' => '3',
                   'fruit' => 'Orange'
                 ],
           '4' =>[
                   'id' => '4',
                   'fruit' => 'Abricot'
                 ]];
    }


}
