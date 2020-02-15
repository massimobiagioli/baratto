<?php

namespace App\Service\Authenticator;

use App\Entity\Utente;
use App\Service\Authenticator\AccessToken;
use App\Service\Authenticator\AuthenticatorInterface;
use Doctrine\Common\Persistence\ObjectManager;

final class AuthenticatorInternal implements AuthenticatorInterface
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function login(string $email, string $password): AccessToken
    {
        $utenteRepository = $this->objectManager->getRepository(Utente::class);
        $utente = $utenteRepository->find(['email' => $email]);
        if (!$utente) {
            throw new \Exception('Utente non trovato');
        }

        $salt = hash('sha256', $utente->getEmail());
        if (!($utente->getPassword() === hash('sha256', $password . $salt))) {
            throw new \Exception('Credenziali non valide');
        }

        $accessToken = AccessToken::newAccessToken();

        //TODO: Salvataggio token su db

        return $accessToken;
    }

    public function logout(AccessToken $accessToken): bool
    {
        // TODO: Rimuovere token da db

        return true;
    }
}
