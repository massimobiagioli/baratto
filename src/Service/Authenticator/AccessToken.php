<?php

namespace App\Service\Authenticator;

use Ramsey\Uuid\Uuid;

final class AccessToken
{
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function newAccessToken()
    {
        $uuid = Uuid::uuid4();
        return new self($uuid->toString());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
