<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $mail; //Unique
    public $password; 
    public $rememberMe = true; // Option pour mémoriser l'utilisateur

    private $_user = false; // Utilisateur récupéré (pour éviter des requêtes multiples)

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // Le pseudo et le mot de passe sont obligatoires
            [['mail', 'password'], 'required'],
            // rememberMe doit être une valeur booléenne
            ['rememberMe', 'boolean'],
            ['mail','email'],
            // Le mot de passe est validé par validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Valide le mot de passe.
     * Cette méthode sert à effectuer la validation inline du mot de passe.
     * @param string $attribute L'attribut actuellement validé
     * @param array $params Les paramètres additionnels fournis à la règle
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            // Si l'utilisateur n'existe pas ou si le mot de passe est invalide
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Email ou mot de passe invalide.');
            }
        }
    }

    /**
     * Connecte un utilisateur en utilisant le pseudo et le mot de passe fournis.
     * @return bool True si la connexion est réussie, false sinon
     */
    public function login()
    {
        if ($this->validate()) {
            // Connexion de l'utilisateur avec session
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Trouve un utilisateur basé sur le pseudo.
     * @return Internaute|null Retourne l'utilisateur ou null s'il n'est pas trouvé
     */
    public function getUser()
    {
        if ($this->_user === false) {
            // Recherche d'un utilisateur avec le pseudo donné
            $this->_user = Internaute::getUserByMail($this->mail);
        }

        return $this->_user;
    }
}

