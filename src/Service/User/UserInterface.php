<?php

namespace App\Service\User;

use App\Entity\Movimento;
use App\Service\User\Ticket;

interface UserInterface
{
    public function sell(int $articoloId, int $venditoreId, int $quantita): void;
    public function buy(int $movimentoId, int $venditoreId): Ticket;
    public function close(int $movimentoId, int $venditoreId): void;
    public function listItemsForSale(int $utenteId): array;
    public function listItemsToBuy(int $utenteId): array;
    public function listItemsPurchased(int $utenteId): array;
    public function listItemsToClose(int $utenteId): array;
    public function residualCoins(int $utenteId): int;
}
