<?php

namespace App\Service\Authenticator;

use App\Service\Authenticator\AccessToken;

interface AuthenticatorInterface
{
    public function login(string $email, string $password): AccessToken;
    public function logout(string $accessToken): void;
    public function verify(string $accessToken): AccessToken;
}
