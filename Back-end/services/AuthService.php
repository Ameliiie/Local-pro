<?php

class AuthService
{
    private $authRepository;

    public function __construct($authRepository)
    {
        $this->authRepository = $authRepository;
    }


    public function login($identifiant, $motDePasse)
    {
        // Vérification des champs identifiant et mot de passe 
        if (empty($identifiant) || empty($motDePasse)) {
            return false;
        }

        // Règles identifiant

        if (strlen($identifiant)>50) {
            return false;
        }

        if (preg_match('/\s/',$identifiant)){
            return false;
        }

        // Règles Mot de passe 

        if (strlen($motDePasse)<8){
            return false;
        }
        
       // Vérification de l'identifiant et du mot de passe  
       $compte = $this->authRepository->getByIdentifiant($identifiant);
       if (!$compte)
        {
            return false;
        } 

       if (password_verify($motDePasse, $compte['mot_de_passe'])) {
            return $compte;
       }

       return false;

    }


    
}