
<?php

require_once __DIR__ . '/../controllers/EntrepriseController.php';

// Faux middleware pour simuler les autorisations
class FakeAuthorizationMiddleware
{
    public $roleAutorise = true;
    public $proprietaireAutorise = true;

    public function authorize($role)
    {
        return $this->roleAutorise;
    }

    public function isEntrepriseOwner($idEntreprise)
    {
        return $this->proprietaireAutorise;
    }
}

// Faux service pour vérifier s'il est appelé
class FakeEntrepriseService
{
    public $appelEffectue = false;

    public function modifierEntreprise($idEntreprise, $donnees)
    {
        $this->appelEffectue = true;
        return true;
    }
}

// Préparation des objets de test
$middleware = new FakeAuthorizationMiddleware();
$service = new FakeEntrepriseService();

$controller = new EntrepriseController($middleware, $service);

// Test 1 : rôle et propriétaire autorisés
$resultat = $controller->modifierEntreprise(1, []);
var_dump($resultat === true);
var_dump($service->appelEffectue === true);

// Test 2 : rôle refusé
$service->appelEffectue = false;
$middleware->roleAutorise = false;

$resultat = $controller->modifierEntreprise(1, []);
var_dump($resultat === false);
var_dump($service->appelEffectue === false);

// Test 3 : propriétaire refusé
$middleware->roleAutorise = true;
$middleware->proprietaireAutorise = false;

$resultat = $controller->modifierEntreprise(1, []);
var_dump($resultat === false);
var_dump($service->appelEffectue === false);
