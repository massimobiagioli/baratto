<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovimentoRepository")
 */
class Movimento
{
    const TIPO_ACQUISTO = 'A';
    const TIPO_VENDITA = 'V';

    const STATO_INSERITO = 'I';
    const STATO_ACQUISTATO = 'A';
    const STATO_EVASO = 'E';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $tipo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dataOperazione;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Articolo", fetch="EAGER")
     */
    private $articolo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utente", fetch="EAGER")
     */
    private $venditore;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utente", fetch="EAGER")
     */
    private $compratore;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantita;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $stato;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ticket;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getDataOperazione(): ?\DateTimeInterface
    {
        return $this->dataOperazione;
    }

    public function setDataOperazione(\DateTimeInterface $dataOperazione): self
    {
        $this->dataOperazione = $dataOperazione;

        return $this;
    }
    
    public function getArticolo(): ?Articolo
    {
        return $this->articolo;
    }

    public function setArticolo(?Articolo $articolo): self
    {
        $this->articolo = $articolo;

        return $this;
    }

    public function getVenditore(): ?Utente
    {
        return $this->venditore;
    }

    public function setVenditore(?Utente $venditore): self
    {
        $this->venditore = $venditore;

        return $this;
    }

    public function getCompratore(): ?Utente
    {
        return $this->compratore;
    }

    public function setCompratore(?Utente $compratore): self
    {
        $this->compratore = $compratore;

        return $this;
    }

    public function getQuantita(): ?int
    {
        return $this->quantita;
    }

    public function setQuantita(int $quantita): self
    {
        $this->quantita = $quantita;

        return $this;
    }

    public function getStato(): ?string
    {
        return $this->stato;
    }

    public function setStato(string $stato): self
    {
        $this->stato = $stato;

        return $this;
    }

    public function getTicket(): ?string
    {
        return $this->ticket;
    }

    public function setTicket(?string $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }
}
