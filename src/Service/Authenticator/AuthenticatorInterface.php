<?php

namespace App\Service\Authenticator;

interface AuthenticatorInterface
{
    public function authenticate(string $email, string $password): bool;
}
