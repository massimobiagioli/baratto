<?php
namespace App\Tests\Service\Admin;

use App\Entity\Articolo;
use App\Entity\Movimento;
use App\Entity\Utente;
use App\Service\User\Ticket;
use App\Service\User\UserDoctrineImpl;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $objectManager;
    private $adminService;

    protected function setUp()
    {
        $articoli = [];

        $articolo1 = new Articolo();
        $articolo1->setId(1);
        $articolo1->setNome('Sviluppo backend PHP (1h)');
        $articolo1->setMonete(20);
        $articoli[] = $articolo1;

        $articolo2 = new Articolo();
        $articolo2->setId(1);
        $articolo2->setNome('Sviluppo frontend ReactJs (1h)');
        $articolo2->setMonete(10);
        $articoli[] = $articolo2;
        
        $articoloRepository = $this->createMock(ArticoloRepository::class);     
        $args = [
            [1, null, null, $articolo1],
            [9, null, null, null]
        ];       
        $articoloRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValueMap($args));

        $movimenti = [];

        $movimento1 = new Movimento();
        $movimento1->setId(1);
        $movimenti[] = $movimento1;

        $movimento2 = new Movimento();
        $movimento2->setId(2);
        $movimenti[] = $movimento2;

        $movimento3 = new Movimento();
        $movimento3->setId(3);
        $movimenti[] = $movimento3;

        $movimento4 = new Movimento();
        $movimento4->setId(4);
        $movimenti[] = $movimento4;
        $forSale = [$movimento1, $movimento2, $movimento3];
        $purchased = [$movimento4];

        $movimentoRepository = $this->createMock(MovimentoRepository::class);     
        $args = [
            [['tipo' => Movimento::TIPO_VENDITA, 'stato' => Movimento::STATO_INSERITO], null, null, null, $forSale],            
            [['tipo' => Movimento::TIPO_ACQUISTO, 'stato' => Movimento::STATO_ACQUISTATO], null, null, null, $purchased]
        ];       
        $movimentoRepository->expects($this->any())
            ->method('findBy')
            ->will($this->returnValueMap($args));

        $utenti = [];

        $utente1 = new Utente();
        $utenti[] = $utente1;

        $utente2 = new Utente();
        $utenti[] = $utente2;

        $args = [
            [1, null, null, $utente1],
            [2, null, null, $utente2]
        ];       
        $utenteRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValueMap($args));

        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $args = [
            [Articolo::class, $articoloRepository],
            [Movimento::class, $movimentoRepository],
            [Utente::class, $utenteRepository]
        ];   
        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValueMap($args));

        $this->entityManager->expects($this->any())
            ->method('persist')
            ->willReturn(true);

        $this->entityManager->expects($this->any())
            ->method('flush')
            ->willReturn(true);

        $this->userService = new UserDoctrineImpl($this->entityManager);
    }

    public function test_sell_returns_void()
    {
        $this->userService->sell($articoloId, $venditoreId, $quantita);
    }

    public function test_buy_with_right_availability_returns_a_valid_ticket()
    {
        $ticket = $this->userService->buy($movimentoId, $articoloId, $venditoreId);
        $ret = preg_match('/[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/', $ticket->getValue(), $matches);
        $this->assertNotNull($ticket);
        $this->assertEquals(1, $ret);
        $this->assertEquals($ticket->getValue(), $matches[0]);
    }

    public function test_buy_with_wrong_availability_returns_a_valid_ticket()
    {
        $this->expectException(\Exception::class);
        $ticket = $this->userService->buy($movimentoId, $articoloId, $venditoreId);
    }

    public function test_list_items_for_sale_returns_the_right_list()
    {
        $movimenti = $this->userService->listItemsForSale($utenteId);
        $this->assertEquals(1, count($movimenti));
    }

    public function test_list_residual_coins_returns_the_right_value()
    {
        $residualCoins = $this->userService->residualCoins($utenteId);
        $this->assertEquals(50, count($residualCoins));
    }

    public function test_list_items_to_buy_returns_the_right_list()
    {
        $movimenti = $this->userService->listItemsToBuy($utenteId);
        $this->assertEquals(2, count($movimenti));
    }

    public function test_list_items_purchased_returns_the_right_list()
    {
        $movimenti = $this->userService->listItemsPurchased($utenteId);
        $this->assertEquals(1, count($movimenti));
    }

}
