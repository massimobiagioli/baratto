<?php
namespace App\Tests\Service\Admin;

use App\Entity\Articolo;
use App\Repository\ArticoloRepository;
use App\Service\Admin\AdminDoctrineImpl;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
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

        $articoloRepository->expects($this->any())
          ->method('findAll')
          ->willReturn($articoli);

        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->entityManager->expects($this->any())
          ->method('getRepository')
          ->willReturn($articoloRepository);

        $this->entityManager->expects($this->any())
          ->method('persist')
          ->willReturn(true);

        $this->entityManager->expects($this->any())
          ->method('flush')
          ->willReturn(true);

        $this->adminService = new AdminDoctrineImpl($this->entityManager);
    }

    public function test_list_articoli_returns_all_articles()
    {
        $articoli = $this->adminService->listArticoli();
        $this->assertEquals(2, count($articoli));
    }

    public function test_get_articolo_with_valid_id_returns_articolo()
    {
        $articolo = $this->adminService->getArticolo(1);
        $this->assertNotNull($articolo);
        $this->assertEquals('Sviluppo backend PHP (1h)', $articolo->getNome());
        $this->assertEquals(20, $articolo->getMonete());
    }

    public function test_get_articolo_with_wrong_id_raise_exception()
    {
        $this->expectException(\Exception::class);
        $articolo = $this->adminService->getArticolo(9);
    }

    public function test_insert_articolo_returns_inserted_articolo()
    {        
        $articoloNew = new Articolo();        
        $articoloNew->setNome('Consulenza RDBMS Oracle (1h)');
        $articoloNew->setMonete(50);
        $articolo = $this->adminService->insertArticolo($articoloNew);
        $this->assertNotNull($articolo);
    }

    public function test_insert_articolo_with_empty_name_raise_exception()
    {
        $articoloNew = new Articolo();        
        $articoloNew->setNome('');
        $articoloNew->setMonete(1);
        $this->expectException(\Exception::class);
        $articolo = $this->adminService->insertArticolo($articoloNew);        
    }

    public function test_update_articolo_with_valid_id_returns_modified_articolo()
    {
        $articolo = new Articolo();        
        $articolo->setNome('Sviluppo backend PHP - Framework Symfony (1h)');
        $articolo->setMonete(25);
        $articolo = $this->adminService->updateArticolo(1, $articolo);       
        $this->assertNotNull($articolo);
        $this->assertEquals(1, $articolo->getId());        
    }

    public function test_update_articolo_with_wrong_id_raise_exception()
    {
        $articolo = new Articolo();        
        $articolo->setNome('Sviluppo backend PHP - Framework Symfony (1h)');
        $articolo->setMonete(25);
        $this->expectException(\Exception::class);
        $articolo = $this->adminService->updateArticolo(9, $articolo);   
    }

    public function test_delete_articolo_with_valid_id_returns_void()
    {
        $this->adminService->deleteArticolo(1);  
        $this->assertTrue(TRUE);  
    }

    public function test_delete_articolo_with_wrong_id_raise_exception()
    {
        $this->expectException(\Exception::class);
        $this->adminService->deleteArticolo(9);    
    }

}
