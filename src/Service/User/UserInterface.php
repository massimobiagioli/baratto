<?php

namespace App\Service\User;

use App\Entity\Movimento;
use App\Service\User\Ticket;

interface UserInterface
{
    public function sell(int $articoloId, int $venditoreId, int $quantita): void;
    public function buy(int $movimentoId, int $articoloId, int $venditoreId): Ticket;
    public function listItemsForSale(int $utenteId): array;
    public function listItemsToBuySale(int $utenteId): array;
    public function listItemsPurchased(int $utenteId): array;
    public function residualCoins(int $utenteId): int;
}
