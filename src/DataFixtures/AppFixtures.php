<?php

namespace App\DataFixtures;

use App\Entity\Articolo;
use App\Entity\Utente;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $utenti = $this->getUtenti();
        foreach ($utenti as $utente) {
            $manager->persist($utente);
        }

        $articoli = $this->getArticoli();
        foreach ($articoli as $articolo) {
            $manager->persist($articolo);
        }

        $manager->flush();
    }

    private function getUtenti(): array
    {
        $utenti = [];

        $utente = new Utente();
        $utente->setEmail('roger.green@gmail.com');
        $secret = 'Zxc123.';
        $utente->setPassword($this->calculatePasswordHash($utente, $secret));
        $utente->setNome('Roger');
        $utente->setCognome('Green');
        $utente->setAmministratore(true);
        $utenti[] = $utente;

        $utente = new Utente();
        $utente->setEmail('frank.black@gmail.com');
        $secret = 'Asd456?';
        $utente->setPassword($this->calculatePasswordHash($utente, $secret));
        $utente->setNome('Frank');
        $utente->setCognome('Black');
        $utente->setAmministratore(false);
        $utenti[] = $utente;

        $utente = new Utente();
        $utente->setEmail('jennifer.white@gmail.com');
        $secret = 'Qwe789!';
        $utente->setPassword($this->calculatePasswordHash($utente, $secret));
        $utente->setNome('Jennifer');
        $utente->setCognome('White');
        $utente->setAmministratore(false);
        $utenti[] = $utente;

        return $utenti;
    }

    private function getArticoli(): array
    {
        $articoli = [];

        $articolo = new Articolo();
        $articolo->setNome('Sviluppo app nativa iOS (1h)');
        $articolo->setMonete(10);
        $articoli[] = $articolo;

        $articolo = new Articolo();
        $articolo->setNome('Sviluppo app nativa Android (1h)');
        $articolo->setMonete(10);
        $articoli[] = $articolo;

        $articolo = new Articolo();
        $articolo->setNome('Sviluppo app cross-platform con Ionic (1h)');
        $articolo->setMonete(5);
        $articoli[] = $articolo;

        $articolo = new Articolo();
        $articolo->setNome('Sviluppo backend NodeJs (1h)');
        $articolo->setMonete(5);
        $articoli[] = $articolo;

        $articolo = new Articolo();
        $articolo->setNome('Sviluppo backend PHP (1h)');
        $articolo->setMonete(8);
        $articoli[] = $articolo;

        $articolo = new Articolo();
        $articolo->setNome('');
        $articolo->setMonete(10);
        $articoli[] = $articolo;

        return $articoli;
    }

    private function calculatePasswordHash(Utente $utente, string $secret): string
    {
        $salt = hash('sha256', $utente->getEmail());
        return hash('sha256', $secret . $salt);
    }
}
