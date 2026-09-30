<?php

class CategorieRepository
{

    // Connexion à la base de données utilisée par le repository
    private $connectionPdo;

    public function __construct($pdo)
    {
        $this->connectionPdo = $pdo;
    }

    // Récupère toutes les catégories
    public function getAll()
    {
        $result = $this->connectionPdo->query("SELECT * FROM categorie");
    // Récupère toutes les lignes retournées par la requête
        $categories = $result->fetchAll();
        return $categories;
    }

    //Récupère une catégorie à partir de son identifiant
    public function getById($id)
    {
        $result =$this->connectionPdo->prepare("SELECT * FROM categorie WHERE id_categorie = :idCategorie");
        $result->execute(['idCategorie' => $id]);
        $resultat = $result-> fetch() ;
        return $resultat;

    }

    // Récupère une catégorie à partir de son nom

    public function getByName($nom)
    {
        $result =$this->connectionPdo->prepare("SELECT * FROM categorie WHERE nom = :nom");
        $result->execute(['nom'=> $nom]);
        $resultat = $result->fetch() ;
        return $resultat;
    }

}