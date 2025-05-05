<?php

namespace app\models;
use yii\db\ActiveRecord;

class User  extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $identifiant;
    public $nom;
    public $prenom;
    public $motpasse;
    public $avatar;
    public $statut_connexion;
    public $authKey;
    public $accessToken;
    


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = MyUsers::findOne(['id'=>$id]);
        return $user ? new  static($user->toArray()): null ; // retourner les données de User dans un tableau 
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user =MyUsers::findOne(['avatar'=>$token]);
        return $user ? new static($user->toArray()) : null ;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = MyUsers::findOne(['identifiant'=>$username]);
        return $user ? new static ($user->toArray()) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->motpasse === sha1($password);// === : verifie à la fois la valeur et le type de donnés 
    }
}
