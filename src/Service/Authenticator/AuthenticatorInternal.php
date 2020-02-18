<?php

namespace App\Service\Authenticator;

use App\Entity\Token;
use App\Entity\Utente;
use App\Service\Authenticator\AccessToken;
use App\Service\Authenticator\AuthenticatorInterface;
use Doctrine\ORM\EntityManagerInterface;

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

    public function logout(string $accessToken): void
    {
        $tokenRepository = $this->entityManager->getRepository(Token::class);
        $token = $tokenRepository->findOneBy(['accessToken' => $accessToken]);
        if (!$token) {
            throw new \Exception('Token non valido');
        }
        $this->entityManager->remove($token);
        $this->entityManager->flush();
    }

    public function verify(string $tokenKey): AccessToken
    {
        $tokenRepository = $this->entityManager->getRepository(Token::class);
        $utenteRepository = $this->entityManager->getRepository(Utente::class);
        $token = $tokenRepository->findOneBy(['accessToken' => $tokenKey]);
        if (!$token) {
            throw new \Exception('Token non trovato');
        }
        $utente = $utenteRepository->find($token->getIdUtente());
        if (!$utente) {
            throw new \Exception('Utente non trovato');
        }
        $accessToken = AccessToken::fromToken($tokenKey, $utente->getAmministratore());

        return $accessToken;
    }

}
