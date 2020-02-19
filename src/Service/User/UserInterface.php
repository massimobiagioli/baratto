<?php

namespace App\Service\User;

use App\Entity\Movimento;

interface UserInterface
{
    public function sell(int $articoloId, int $venditoreId, int $quantita): void;
    public function listItemsForSale(int $utenteId): array;
    public function residualCoins(int $utenteId): int;
}
