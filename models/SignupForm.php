<?php

namespace app\models;

use yii\base\Model;
use app\models\Internaute;
use Yii;

class SignupForm extends Model
{
    public $id;    public $pseudo;    public $pass;    public $nom;    public $prenom;    public $mail;    public $photo;    public $permis;

    public function rules()
    {
        return [
            [['nom', 'prenom', 'pseudo', 'mail', 'pass'], 'required'],
            [['nom', 'prenom', 'pseudo', 'photo'], 'string', 'max' => 255],
            ['pseudo', 'string', 'max' => 45],  
            ['mail', 'string', 'max' => 45],
            ['pass', 'string', 'max' => 45],
            ['photo', 'string', 'max' => 200], 
            ['mail', 'email'], 
            ['permis', 'default', 'value' => null],
            ['permis', 'number', 'integerOnly' => true], 
        ];
    }

    /**
     *création d'un nouvel utilisateur
     * @return array Résultat avec notifications
     */
    public function signup()
    {
        if (!$this->validate()) {
            return [
                'notifications' => [['type' => 'warning','message' => 'Veuillez vérifier les informations saisies.',],],
            ];
        }
      
        // Vérifier si l'utilisateur existe déjà (pseudo ou email)
        $existingUser = Internaute::getUserByPseudoOrEmail($this->pseudo, $this->mail);
        if ($existingUser) {
            return [
                'notifications' => [['type' => 'error','message' => 'Un utilisateur avec ce pseudo ou cet email existe déjà.',],],
            ];
        }
        //créer un nouvel utilisateur
        $user = new Internaute();
        $user->nom = $this->nom;
        $user->prenom = $this->prenom;
        $user->pseudo = $this->pseudo;
        $user->mail = $this->mail;
        $user->pass = sha1($this->pass);
        $user->photo = $this->photo;
        $user->permis = $this->permis;

        if ($user->save()) {
            return [
                'notifications' => [['type' => 'success','message' => 'Votre compte a été créé avec succès.',],],
            ];
        }
        return [
                'notifications' => [['type' => 'error','message' => 'Une erreur est survenue lors de la création du compte.',],],
            ];
    }
}

