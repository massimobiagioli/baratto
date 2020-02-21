<?php
namespace App\Tests\Service\Admin;

use App\Entity\Articolo;
use App\Entity\Movimento;
use App\Entity\Utente;
use App\Repository\ArticoloRepository;
use App\Repository\MovimentoRepository;
use App\Repository\UtenteRepository;
use App\Service\User\UserDoctrineImpl;
use Doctrine\ORM\EntityManagerInterface;
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
        $articolo2->setId(2);
        $articolo2->setNome('Sviluppo frontend ReactJs (1h)');
        $articolo2->setMonete(10);
        $articoli[] = $articolo2;

        $articoloRepository = $this->createMock(ArticoloRepository::class);
        $args = [
            [1, null, null, $articolo1],
            [9, null, null, null],
        ];
        $articoloRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValueMap($args));

        $utenti = [];

        $utente1 = new Utente();
        $utente1->setId(1);
        $utente1->setEmail('franco.rossi@gmail.com');
        $utente1->setMonete(100);
        $utenti[] = $utente1;

        $utente2 = new Utente();
        $utente2->setId(2);
        $utente2->setEmail('lucio.neri@gmail.com');
        $utente2->setMonete(100);
        $utenti[] = $utente2;

        $utente3 = new Utente();
        $utente3->setId(3);
        $utente3->setEmail('piero.verdi@gmail.com');
        $utente3->setMonete(5);
        $utenti[] = $utente2;

        $utenteRepository = $this->createMock(UtenteRepository::class);
        $args = [
            [1, null, null, $utente1],
            [2, null, null, $utente2],
        ];
        $utenteRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValueMap($args));
    
        $movimenti = [];

        $movimento1 = new Movimento();
        $movimento1->setId(1);
        $movimento1->setArticolo($articolo1);
        $movimento1->setVenditore($utente1);
        $movimento1->setQuantita(1);        
        $movimento1->setTipo(Movimento::TIPO_VENDITA);
        $movimento1->setStato(Movimento::STATO_INSERITO);
        $movimenti[] = $movimento1;

        $movimento2 = new Movimento();
        $movimento2->setId(2);
        $movimento2->setArticolo($articolo1);
        $movimento2->setVenditore($utente1);
        $movimento2->setQuantita(2);
        $movimento2->setTipo(Movimento::TIPO_VENDITA);
        $movimento2->setStato(Movimento::STATO_INSERITO);
        $movimenti[] = $movimento2;

        $movimento3 = new Movimento();
        $movimento3->setId(3);
        $movimento3->setArticolo($articolo2);
        $movimento3->setVenditore($utente1);
        $movimento3->setQuantita(3);
        $movimento3->setTipo(Movimento::TIPO_VENDITA);
        $movimento3->setStato(Movimento::STATO_INSERITO);
        $movimenti[] = $movimento3;

        $movimento4 = new Movimento();
        $movimento4->setId(4);
        $movimento4->setArticolo($articolo2);
        $movimento4->setVenditore($utente1);
        $movimento4->setCompratore($utente2);
        $movimento4->setIdMovimentoVendita(1);
        $movimento4->setQuantita(3);
        $movimento4->setTipo(Movimento::TIPO_ACQUISTO);
        $movimento4->setStato(Movimento::STATO_ACQUISTATO);
        $movimenti[] = $movimento4;
        $forSale = [$movimento1, $movimento2, $movimento3];
        $purchased = [$movimento4];
        $movimentoRepository = $this->createMock(MovimentoRepository::class);
        $args = [
            [
                ['tipo' => Movimento::TIPO_VENDITA, 'stato' => Movimento::STATO_INSERITO], 
                ['dataOperazione' => 'DESC'], 
                null, null, $forSale
            ],
            [
                ['tipo' => Movimento::TIPO_ACQUISTO, 'stato' => Movimento::STATO_ACQUISTATO], 
                ['dataOperazione' => 'DESC'],
                null, null, $purchased
            ],
        ];
        $movimentoRepository->expects($this->any())
            ->method('findBy')
            ->will($this->returnValueMap($args));
        
        $args = [
              [1, null, null, $movimento1],
              [2, null, null, $movimento2],
              [3, null, null, $movimento3],
              [4, null, null, $movimento4]
        ];
        $movimentoRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValueMap($args));

        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $args = [
            [Articolo::class, $articoloRepository],
            [Movimento::class, $movimentoRepository],
            [Utente::class, $utenteRepository],
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
        $articoloId = 1;
        $venditoreId = 1;
        $quantita = 1;
        $this->userService->sell($articoloId, $venditoreId, $quantita);
        $this->assertTrue(TRUE);
    }

    public function test_buy_with_right_availability_returns_a_valid_ticket()
    {
        $movimentoId = 1;
        $compratoreId = 1;
        $ticket = $this->userService->buy($movimentoId, $compratoreId);
        $ret = preg_match('/[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/', $ticket->getValue(), $matches);
        $this->assertNotNull($ticket);
        $this->assertEquals(1, $ret);
        $this->assertEquals($ticket->getValue(), $matches[0]);
    }

    public function test_buy_with_wrong_availability_returns_exception()
    {
        $this->expectException(\Exception::class);
        $movimentoId = 1;
        $compratoreId = 3;
        $ticket = $this->userService->buy($movimentoId, $compratoreId);
    }

    public function test_close_returns_void()
    {
        $movimentoId = 1;
        $venditoreId = 1;
        $quantita = 1;
        $this->userService->close($movimentoId, $venditoreId, $quantita);
        $this->assertTrue(TRUE);
    }

    public function test_list_items_for_sale_returns_the_right_list()
    {
        $utenteId = 1;
        $movimenti = $this->userService->listItemsForSale($utenteId);
        $this->assertEquals(3, count($movimenti));
    }

    public function test_list_residual_coins_returns_the_right_value()
    {
        $utenteId = 1;
        $residualCoins = $this->userService->residualCoins($utenteId);
        $this->assertEquals(100, $residualCoins);
    }

    public function test_list_items_to_buy_returns_the_right_list()
    {
        $utenteId = 2;
        $movimenti = $this->userService->listItemsToBuy($utenteId);
        $this->assertEquals(3, count($movimenti));
    }

    public function test_list_items_purchased_returns_the_right_list()
    {
        $utenteId = 1;
        $movimenti = $this->userService->listItemsPurchased($utenteId);
        $this->assertEquals(0, count($movimenti));
    }

    public function test_list_items_to_close_returns_the_right_list()
    {
        $utenteId = 1;
        $movimenti = $this->userService->listItemsToClose($utenteId);
        $this->assertEquals(1, count($movimenti));
    }

}
