<?php

namespace App\Service\Authenticator;

use Ramsey\Uuid\Uuid;

final class Ticket
{
    private $value;

    private function __construct(string $value)
    {
        $uuid = Uuid::uuid4();        
        $this->value = $uuid->toString();
    }
   
    public function getValue(): string
    {
        return $this->value;
    }
    
}
