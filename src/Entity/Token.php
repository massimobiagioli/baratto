<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TokenRepository")
 */
class Token
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $accessToken;

    /**
     * @ORM\Column(type="integer")
     */
    private $idUtente;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function getIdUtente(): ?int
    {
        return $this->idUtente;
    }

    public function setIdUtente(int $idUtente): self
    {
        $this->idUtente = $idUtente;

        return $this;
    }
}
