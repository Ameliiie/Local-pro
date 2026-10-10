<?php

class AuthorizationMiddleware
{
    // Repository permettant d'accéder aux données des utilisateurs
    private $utilisateurRepository;
    private $professionnelRepository;
    private $entrepriseRepository;

    // Reçoit les repositories lors de la création du middleware
    public function __construct($utilisateurRepository, $professionnelRepository, $entrepriseRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->professionnelRepository = $professionnelRepository;
        $this->entrepriseRepository = $entrepriseRepository;
    }

    public function authorize($role)
    {
        if (!isset($_SESSION['type_compte'])) {
            return false;
        }

        $typeCompte = $_SESSION['type_compte'];

        if ($role !== $typeCompte) {
            return false;
        }

        return true;
    }

    // Vérifie si l'utilisateur connecté correspond à l'utilisateur demandé
    public function isOwner($idUtilisateur)
    {
        if (!isset($_SESSION['id_compte'])) {
            return false;
        }

        $utilisateur = $this->utilisateurRepository->getByIdCompte($_SESSION['id_compte']);

        if (!$utilisateur) {
            return false;
        }

        if ($utilisateur['id_utilisateur'] !== $idUtilisateur) {
            return false;
        }

        return true;
    }

    public function isEntrepriseOwner($idEntreprise)
    {
        if (!isset($_SESSION['id_compte'])) {
            return false;
        }
        $idCompte =$_SESSION['id_compte'];

        $professionnel = $this->professionnelRepository->getByIdCompte($idCompte);

        if (!$professionnel) {
            return false;
        }    

        $idProfessionnel = $professionnel['id_professionnel'];
        $entreprises = $this->entrepriseRepository->getByIdProfessionnel($idProfessionnel);
        foreach ($entreprises as $entreprise) {
        if ((int) $entreprise['id_entreprise'] === (int) $idEntreprise) {
            
        return true;
        }
        }

        return false;      
    }

    public function canModifyEntreprise($idEntreprise){
        if (!$this->isEntrepriseOwner($idEntreprise)){
            return false;
        }
    }    
}