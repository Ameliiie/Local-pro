
<?php

class EntrepriseService
{
    private $entrepriseRepository;

    public function __construct($entrepriseRepository)
    {
        $this->entrepriseRepository = $entrepriseRepository;
    }

    // Vérifie les données communes à la création et à la modification
    public function hasValidCommonData($donnees)
    {
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
                || !is_string($donnees[$champ])
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

    // Vérifie les données avant la modification d'une entreprise
    public function canModifyEntreprise($donnees)
    {
        if (array_key_exists('etat', $donnees)) {
            return false;
        }

        return $this->hasValidCommonData($donnees);
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

    // Vérifie si un SIRET est valide et disponible
    public function isSiretUnique($siret, $idEntreprise = null)
    {
        if (
            !is_string($siret)
            || !preg_match('/^\d{14}$/', $siret)
        ) {
            return false;
        }

        $entrepriseExistante = $this->entrepriseRepository->getBySiret($siret);

        if (!$entrepriseExistante) {
            return true;
        }

        if (
            $idEntreprise !== null
            && (int) $entrepriseExistante['id_entreprise'] === (int) $idEntreprise
        ) {
            return true;
        }

        return false;
    }

    // Vérifie les données avant la création d'une entreprise
    public function canCreateEntreprise($donnees)
    {
        // Vérifie les données communes
        if (!$this->hasValidCommonData($donnees)) {
            return false;
        }

        // Le SIRET est obligatoire lors d'une création
        if (
            !isset($donnees['siret'])
            || !is_string($donnees['siret'])
        ) {
            return false;
        }

        // Vérifie le format et l'unicité du SIRET
        if (!$this->isSiretUnique($donnees['siret'])) {
            return false;
        }

        return true;
    }

    // Vérifie les données puis crée une entreprise
    public function createEntreprise($donnees, $id_professionnel)
    {
        if (!$this->canCreateEntreprise($donnees)) {
            return false;
        }

        return $this->entrepriseRepository->create(
            $donnees,
            $id_professionnel
        );
    }
}
