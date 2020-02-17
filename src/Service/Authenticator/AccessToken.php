<?php

namespace App\Service\Authenticator;

use Ramsey\Uuid\Uuid;

final class AccessToken
{
    private $value;
    private $allowAdmin;

    private function __construct(string $value, bool $allowAdmin)
    {
        $this->value = $value;
        $this->allowAdmin = $allowAdmin;
    }

    public static function newAccessToken(bool $allowAdmin)
    {
        $uuid = Uuid::uuid4();
        return new self($uuid->toString(), $allowAdmin);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getAllowAdmin(): bool
    {
      return $this->allowAdmin;
    }
}
