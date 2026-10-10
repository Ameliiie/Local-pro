<?php

class ProfessionnelRepository
{
    private $connectionPdo;
    public function __construct($pdo)
    {
        $this->connectionPdo = $pdo;
    }
    public function getByIdCompte($idCompte)
    {
        $result = $this->connectionPdo->prepare("SELECT * FROM professionnel WHERE id_compte = :idCompte");
        $result->execute(['idCompte' => $idCompte]);
        $professionnel = $result->fetch();

        return $professionnel;
    }
}