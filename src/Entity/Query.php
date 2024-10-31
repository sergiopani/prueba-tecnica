<?php
// src/Entity/Query.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QueryRepository")
 */
class Query
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $queryString;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $questions = [];

    // Getters y Setters...

    public function getQuestionsData(): array
    {
        return $this->questions;
    }

    public function setQuestionsData(array $questions): self
    {
        $this->questions = $questions;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getQueryString(): string
    {
        return $this->queryString;
    }

    public function setQueryString(string $queryString): self
    {
        $this->queryString = $queryString;

        return $this;
    }
}
