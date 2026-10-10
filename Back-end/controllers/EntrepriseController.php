
<?php

class EntrepriseController
{
    private $authorizationMiddleware;
    private $entrepriseService;

    public function __construct(
        $authorizationMiddleware,
        $entrepriseService
    ) {
        $this->authorizationMiddleware = $authorizationMiddleware;
        $this->entrepriseService = $entrepriseService;
    }

    // Modifie les informations d'une entreprise
    public function modifierEntreprise($idEntreprise, $donnees)
    {
        // Vérifie que le compte connecté est un professionnel
        if (!$this->authorizationMiddleware->authorize('professionnel')) {
            return false;
        }

        // Vérifie que l'entreprise appartient au professionnel connecté
        if (!$this->authorizationMiddleware->isEntrepriseOwner($idEntreprise)) {
            return false;
        }

        // Vérifie les données et demande la modification
        return $this->entrepriseService->modifierEntreprise(
            $idEntreprise,
            $donnees
        );
    }
}
