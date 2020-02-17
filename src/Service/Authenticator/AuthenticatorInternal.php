<?php

namespace App\Service\Authenticator;

use App\Entity\Token;
use App\Entity\Utente;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Authenticator\AccessToken;
use App\Service\Authenticator\AuthenticatorInterface;

final class AuthenticatorInternal implements AuthenticatorInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function login(string $email, string $password): AccessToken
    {
        $utenteRepository = $this->entityManager->getRepository(Utente::class);
        $utente = $utenteRepository->findOneBy(['email' => $email]);
        if (!$utente) {
            throw new \Exception('Utente non trovato');
        }

        $salt = hash('sha256', $utente->getEmail());
        if (!($utente->getPassword() === hash('sha256', $password . $salt))) {
            throw new \Exception('Credenziali non valide');
        }

        $accessToken = AccessToken::newAccessToken($utente->getAmministratore());

        $token = new Token();
        $token->setIdUtente($utente->getId());
        $token->setAccessToken($accessToken->getValue());
        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return $accessToken;
    }

    public function logout(string $accessToken): bool
    {
        $tokenRepository = $this->entityManager->getRepository(Token::class);
        $token = $tokenRepository->findOneBy(['accessToken' => $accessToken]);
        if (!$token) {
          return false;
        }

        $this->entityManager->remove($token);   
        $this->entityManager->flush();     

        return true;
    }

}
