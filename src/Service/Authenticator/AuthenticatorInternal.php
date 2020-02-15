<?php

namespace App\Service\Authenticator;

use App\Entity\Utente;
use App\Service\Authenticator\AuthenticatorInterface;
use Doctrine\Common\Persistence\ObjectManager;

final class AuthenticatorInternal implements AuthenticatorInterface
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function authenticate(string $email, string $password): bool
    {
        $utenteRepository = $this->objectManager->getRepository(Utente::class);
        $utente = $utenteRepository->find(['email' => $email]);
        if (!$utente) {
            return false;
        }
        $salt = hash('sha256', $utente->getEmail());
        return $utente->getPassword() === hash('sha256', $password . $salt);
    }
}
