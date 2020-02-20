<?php

namespace App\Service\User;

use App\Entity\Articolo;
use App\Entity\Movimento;
use App\Entity\Utente;
use App\Service\User\UserInterface;
use App\Service\User\Ticket;
use Doctrine\ORM\EntityManagerInterface;

final class UserDoctrineImpl implements UserInterface
{
    private $entityManager;
    private $movimentoRepository;
    private $utenteRepository;
    private $articoloRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->movimentoRepository = $this->entityManager->getRepository(Movimento::class);
        $this->utenteRepository = $this->entityManager->getRepository(Utente::class);
        $this->articoloRepository = $this->entityManager->getRepository(Articolo::class);
    }

    public function sell(int $articoloId, int $venditoreId, int $quantita): void
    {
        $venditore = $this->utenteRepository->find($venditoreId);
        if (!$venditore) {
            throw new \Exception("Venditore non trovato");
        }
        $articolo = $this->articoloRepository->find($articoloId);
        if (!$articolo) {
            throw new \Exception("Articolo non trovato");
        }

        $movimento = new Movimento();
        $movimento->setArticolo($articolo);
        $movimento->setVenditore($venditore);
        $movimento->setQuantita($quantita);
        $movimento->setDataOperazione(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
        $movimento->setTipo(Movimento::TIPO_VENDITA);
        $movimento->setStato(Movimento::STATO_INSERITO);

        $this->validateMovimento($movimento);

        $this->entityManager->persist($movimento);
        $this->entityManager->flush();
    }

    public function buy(int $movimentoId, int $compratoreId): Ticket
    {
        $compratore = $this->utenteRepository->find($compratoreId);
        if (!$compratore) {
            throw new \Exception("Venditore non trovato");
        }       
        $movimentoVendita = $this->movimentoRepository->find($movimentoId);
        if (!$movimentoVendita) {
            throw new \Exception("Movimento vendita non trovato");
        }
        $articolo = $this->articoloRepository->find($movimentoVendita->getArticolo()->getId());
        if (!$articolo) {
            throw new \Exception("Articolo non trovato");
        }
        
        $quantita = $movimentoVendita->getQuantita();
        $totalPrice = $articolo->getMonete() * $quantita;
        if ($compratore->getMonete() < $totalPrice) {
            throw new \Exception("Disponibilità monete insufficiente");
        }

        $movimento = new Movimento();
        $movimento->setArticolo($articolo);
        $movimento->setVenditore($movimentoVendita->getVenditore());
        $movimento->setCompratore($compratore);
        $movimento->setQuantita($quantita);
        $movimento->setDataOperazione(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
        $movimento->setTipo(Movimento::TIPO_ACQUISTO);
        $movimento->setStato(Movimento::STATO_ACQUISTATO);
        $ticket = new Ticket();
        $movimento->setTicket($ticket->getValue());
        $movimento->setIdMovimentoVendita($movimentoId);
        $this->validateMovimento($movimento);
        $this->entityManager->persist($movimento);
        
        $compratore->setMonete($compratore->getMonete() - $totalPrice);
        $this->entityManager->persist($compratore);

        $this->entityManager->flush();        

        return $ticket;
    }
    
    public function close(int $movimentoId, int $venditoreId): void
    {
        $movimento = $this->movimentoRepository->find($movimentoId);
        if (!$movimento) {
            throw new \Exception("Movimento non trovato");
        }
        $articolo = $this->articoloRepository->find($movimento->getArticolo()->getId());
        if (!$articolo) {
            throw new \Exception("Articolo non trovato");
        }
        $venditore = $this->utenteRepository->find($venditoreId);
        if (!$venditore) {
            throw new \Exception("Venditore non trovato");
        }
        
        $movimento->setStato(Movimento::STATO_EVASO);
        $this->entityManager->persist($movimento);

        $quantita = $movimento->getQuantita();
        $totalPrice = $articolo->getMonete() * $quantita;
        $venditore->setMonete($venditore->getMonete() + $totalPrice);
        $this->entityManager->persist($venditore);

        $this->entityManager->flush();
    }

    public function listItemsForSale(int $utenteId): array
    {
        $criteria = [
            'tipo' => Movimento::TIPO_VENDITA,
            'stato' => Movimento::STATO_INSERITO,
        ];
        $movimenti = $this->movimentoRepository->findBy($criteria, ['dataOperazione' => 'DESC']);
        $movimenti = array_filter($movimenti, function ($m) use ($utenteId) {
            return $m->getVenditore()->getId() === $utenteId;
        });
        return $movimenti;
    }

    public function listItemsToBuy(int $utenteId): array
    {
        $criteria = [
            'tipo' => Movimento::TIPO_VENDITA,
            'stato' => Movimento::STATO_INSERITO,
        ];
        $movimenti = $this->movimentoRepository->findBy($criteria, ['dataOperazione' => 'DESC']);
        $movimenti = array_filter($movimenti, function ($m) use ($utenteId) {
            return $m->getVenditore()->getId() !== $utenteId;
        });
        return $movimenti;
    }

    public function listItemsPurchased(int $utenteId): array
    {
        $criteria = [
            'tipo' => Movimento::TIPO_ACQUISTO,
            'stato' => Movimento::STATO_ACQUISTATO,
        ];
        $movimenti = $this->movimentoRepository->findBy($criteria, ['dataOperazione' => 'DESC']);
        $movimenti = array_filter($movimenti, function ($m) use ($utenteId) {
            return $m->getCompratore()->getId() === $utenteId;
        });
        return $movimenti;
    }    

    public function listItemsToClose(int $utenteId): array
    {
        $criteria = [
            'tipo' => Movimento::TIPO_ACQUISTO,
            'stato' => Movimento::STATO_ACQUISTATO,
        ];
        $movimenti = $this->movimentoRepository->findBy($criteria, ['dataOperazione' => 'DESC']);
        $movimenti = array_filter($movimenti, function ($m) use ($utenteId) {
            return $m->getVenditore()->getId() === $utenteId;
        });
        return $movimenti;
    }

    public function residualCoins(int $utenteId): int
    {
        $utente = $this->utenteRepository->find($utenteId);
        if (!$utente) {
            throw new \Exception("Utente non trovato");
        }
        return $utente->getMonete();
    }

    private function validateMovimento(Movimento $movimento)
    {
        if ($movimento->getQuantita() < 0) {
            throw new \Exception("Movimento non valido - Specificata quantità negativa");
        }
    }

}
