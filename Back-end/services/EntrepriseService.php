
<?php

class EntrepriseService
{
    private $entrepriseRepository;

    public function __construct($entrepriseRepository)
    {
        $this->entrepriseRepository = $entrepriseRepository;
    }

    // Vérifie les données avant la modification d'une entreprise
    public function canModifyEntreprise($donnees)
    {
        // Le professionnel ne peut pas modifier l'état administratif
        if (array_key_exists('etat', $donnees)) {
            return false;
        }

        // Vérifie les champs obligatoires
        $champsObligatoires = [
            'nom_entreprise',
            'adresse',
            'code_postal',
            'ville'
        ];

        foreach ($champsObligatoires as $champ) {
            if (
                !isset($donnees[$champ])
                || trim($donnees[$champ]) === ''
            ) {
                return false;
            }
        }

        // Vérifie le format du code postal
        if (!preg_match('/^\d{5}$/', $donnees['code_postal'])) {
            return false;
        }

        return true;
    }
    
    // Vérifie les données puis demande au repository de modifier l'entreprise
    public function modifierEntreprise($idEntreprise, $donnees)
    {
        if (!$this->canModifyEntreprise($donnees)) {
            return false;
        }

        return $this->entrepriseRepository->updateInformations(
            $idEntreprise,
            $donnees
        );
    }

}
