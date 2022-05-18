<?php

namespace App\Entity;

use App\Repository\TirageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TirageRepository::class)]
class Tirage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $typeTirage;

    #[ORM\Column(type: 'string', length: 10)]
    private $format;

    #[ORM\Column(type: 'float')]
    private $prix;

    #[ORM\Column(type: 'integer')]
    private $quantite_photo;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeTirage(): ?string
    {
        return $this->typeTirage;
    }

    public function setTypeTirage(string $typeTirage): self
    {
        $this->typeTirage = $typeTirage;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite_photo;
    }

    public function setQuantite(?int $quantite_photo): self
    {
        $this->quantite_photo = $quantite_photo;

        return $this;
    }
   
   



}
