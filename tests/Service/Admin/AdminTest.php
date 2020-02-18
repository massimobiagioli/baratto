<?php
namespace App\Tests\Service\Authenticator;

use App\Entity\Articolo;
use App\Repository\ArticoloRepository;
use App\Service\Admin\AdminDoctrineImpl;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class AuthenticatorTest extends TestCase
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
        
    }

    public function test_get_articolo_with_valid_id_returns_articolo()
    {
        
    }

    public function test_get_articolo_with_wrong_id_raise_exception()
    {
        
    }

    public function test_insert_articolo_returns_inserted_articolo()
    {
        
    }

    public function test_insert_articolo_with_empty_name_raise_exception()
    {
        
    }

    public function test_update_articolo_with_valid_id_returns_modified_articolo()
    {
        
    }

    public function test_update_articolo_with_wrong_id_raise_exception()
    {
        
    }

    public function test_delete_articolo_with_valid_id_returns_void()
    {
        
    }

    public function test_delete_articolo_with_wrong_id_raise_exception()
    {
        
    }

}
