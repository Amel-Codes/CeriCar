<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class MyUsers extends ActiveRecord
{

    // Méthode qui lie la classe à la table `my_users`
    public static function tableName()
    {
        return 'fredouil.my_users';
    }

}

