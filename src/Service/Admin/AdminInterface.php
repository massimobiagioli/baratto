<?php

namespace App\Service\Admin;

use App\Entity\Articolo;

interface AdminInterface
{
    public function listArticoli(): array;
    public function getArticolo(int $id): Articolo;
    public function insertArticolo(Articolo $articolo): Articolo;
    public function updateArticolo(int $id, Articolo $articolo): Articolo;
    public function deleteArticolo(int $id): void;
}
