<?php

class AuthController
{
    private $authService;

    public function __construct($authService)
    {
        $this->authService = $authService;
    }

    public function authenticate($identifiant, $motDePasse)
    {
        $compte = $this->authService->login($identifiant,$motDePasse);
        if ($compte === false) {
        return false;
    }

        $_SESSION['id_compte'] = $compte['id_compte'];
        $_SESSION['type_compte'] = $compte['type_compte'];
        return $compte;

    }

}