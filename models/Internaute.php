<?php
namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\web\IdentityInterface;

class Internaute extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'fredouil.internaute';
    }

    // Récupérer les voyages associés à cet internaute
    public function getVoyages()
    {
        return $this->hasMany(Voyage::class, ['conducteur' => 'id']);
    }

    // Récupérer les réservations associées à cet internaute
    public function getReservations()
    {
        return $this->hasMany(Reservation::class, ['voyageur' => 'id']);
    }

    // Récupérer un internaute par son pseudo
    public static function getUserByIdentifiant($pseudo)
    {
        return self::findOne(['pseudo' => $pseudo]);
    }
    // Récupérer un internaute par son mail
    public static function getUserByMail($mail)
    {
        return self::findOne(['mail' => $mail]);
    }

    // Récupérer un internaute par son pseudo ou email
    public static function getUserByPseudoOrEmail($pseudo, $mail)
    {
      return self::find()
        ->where(['or', ['pseudo' => $pseudo], ['mail' => $mail]])
        ->one();
    }

    // Implémentation de la méthode findIdentity de l'interface IdentityInterface
    public static function findIdentity($id)
    {
        return static::findOne($id);  // Trouver un internaute par son ID
    }

    // Implémentation de la méthode findIdentityByAccessToken (pas utilisé ici, mais nécessaire pour l'interface)
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Pour le moment, nous ne gérons pas les tokens, donc on retourne null
        return null;
    }

    // Implémentation de la méthode getId de l'interface IdentityInterface
    public function getId()
    {
        return $this->id;  // Retourne l'ID de l'internaute
    }

    // Implémentation de la méthode getAuthKey (si vous souhaitez utiliser un système de clé d'authentification)
    public function getAuthKey()
    {
        return null;  // Retourne null si vous ne gérez pas de clé d'authentification
    }

    // Implémentation de la méthode validateAuthKey (si vous utilisez un système de clé d'authentification)
    public function validateAuthKey($authKey)
    {
        return false;  // Retourne false si vous n'utilisez pas de clé d'authentification
    }

    // Méthode pour valider le mot de passe
    public function validatePassword($pass)
    {
        // Hash du mot de passe en SHA-1 pour la comparaison
        $hashedPassword = sha1($pass);  // Hachage du mot de passe fourni par l'utilisateur

        // Comparaison avec le mot de passe stocké en SHA-1 dans la base de données
        return $hashedPassword === $this->pass;
    }
}

?>

