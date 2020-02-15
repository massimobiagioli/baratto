<?php

namespace App\Service\Authenticator;

use App\Service\Authenticator\AccessToken;

interface AuthenticatorInterface
{
    public function login(string $email, string $password): AccessToken;
    public function logout(AccessToken $accessToken): bool;
}
