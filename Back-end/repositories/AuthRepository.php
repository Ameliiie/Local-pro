<?php

class AuthRepository
{
    private $connectionPdo;
    public function __construct($pdo)
    {
        $this->connectionPdo = $pdo;
    }

    public function getByIdentifiant ($identifiant)
    {
        $result =$this->connectionPdo->prepare("SELECT * FROM compte WHERE identifiant = :identifiant");
        $result->execute(['identifiant'=>$identifiant]);
        $resultat = $result->fetch();
        return $resultat;
    }
}