<?php 

Class EntrepriseRepository
{
    private $connectionPdo;
    public function __construct($pdo)
    {
        $this->connectionPdo = $pdo;
    }
    public function getByIdProfessionnel($idProfessionnel)
    {
        $result = $this->connectionPdo->prepare("SELECT * FROM entreprise WHERE id_professionnel = :idProfessionnel");
        $result->execute(['idProfessionnel'=> $idProfessionnel]);
        $entreprises=$result->fetchAll();
        return $entreprises;
    }
    
    public function updateInformations($idEntreprise, $donnees)
    {
        $sql = "UPDATE entreprise SET
                nom_entreprise = :nom,
                adresse = :adresse,
                code_postal = :codePostal,
                ville = :ville,
                telephone = :telephone,
                email_entreprise = :email,
                site_web = :siteWeb,
                description = :description,
                id_categorie = :idCategorie
            WHERE id_entreprise = :idEntreprise";

        $result = $this->connectionPdo->prepare($sql);

        return $result->execute([
            'nom' => $donnees['nom_entreprise'],
            'adresse' => $donnees['adresse'],
            'codePostal' => $donnees['code_postal'],
            'ville' => $donnees['ville'],
            'telephone' => $donnees['telephone'] ?? null,
            'email' => $donnees['email_entreprise'] ?? null,
            'siteWeb' => $donnees['site_web'] ?? null,
            'description' => $donnees['description'] ?? null,
            'idCategorie' => $donnees['id_categorie'] ?? null,
            'idEntreprise' => $idEntreprise
        ]);
    }

    
}