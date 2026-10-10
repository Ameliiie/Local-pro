<?php

class UtilisateurRepository
{
    private $connectionPdo;

    public function __construct($pdo)
    {
        $this->connectionPdo = $pdo;
    }
    
    // Récupère un utilisateur à partir de son identifiant de compte
    public function getByIdCompte($idCompte)
    {
        $result = $this->connectionPdo->prepare("SELECT * FROM utilisateur WHERE id_compte = :idCompte" );
        $result->execute(['idCompte' => $idCompte]);
        $utilisateur = $result->fetch();

        return $utilisateur;
    }
}