<?php

namespace App\Service\User;

use Ramsey\Uuid\Uuid;

final class Ticket
{
    private $value;

    public function __construct()
    {
        $uuid = Uuid::uuid4();        
        $this->value = $uuid->toString();
    }
   
    public function getValue(): string
    {
        return $this->value;
    }
    
}
