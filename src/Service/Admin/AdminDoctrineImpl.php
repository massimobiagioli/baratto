<?php

namespace App\Service\Admin;

use App\Entity\Articolo;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Admin\AdminInterface;

final class AdminDoctrineImpl implements AdminInterface
{
    private $entityManager;
    private $articoloRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->articoloRepository = $this->entityManager->getRepository(Articolo::class);
    }

    public function listArticoli(): array
    {        
        $articoli = $this->articoloRepository->findAll();        
        return $articoli;
    }

    public function getArticolo(int $id): Articolo
    {
        $articolo = $this->articoloRepository->find($id);
        if (!$articolo) {
            throw new \Exception("Articolo non trovato");
        }
        return $articolo;
    }

    public function insertArticolo(Articolo $articolo): Articolo
    {        
        $this->validateArticolo($articolo);                
        $this->entityManager->persist($articolo);
        $this->entityManager->flush();
        return $articolo;
    }

    public function updateArticolo(int $id, Articolo $articolo): Articolo
    {
        $oldArticolo = $this->getArticolo($id);
        $this->validateArticolo($articolo);       
        $oldArticolo->setNome($articolo->getNome());
        $this->entityManager->persist($oldArticolo);
        $this->entityManager->flush();
        return $oldArticolo;
    }

    public function deleteArticolo(int $id): void
    {
        $articolo = $this->getArticolo($id);
        $this->entityManager->remove($articolo);   
        $this->entityManager->flush();
    }

    private function validateArticolo(Articolo $articolo) 
    {
        if (empty($articolo->getNome())) {
            throw new \Exception("Articolo non valido - Campo 'nome' mancante"); 
        }        
    }
       
}
