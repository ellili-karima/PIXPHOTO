<?php

namespace App\Entity;

use App\Entity\Couleur;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DecoMuraleRepository;

#[ORM\Entity(repositoryClass: DecoMuraleRepository::class)]
class DecoMurale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 15)]
    private $support;

    #[ORM\Column(type: 'string', length: 10)]
    private $format;

    #[ORM\Column(type: 'float', nullable: true)]
    private $epaisseur;

    
    #[ORM\Column(type: 'float')]
    private $prix;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $stock;

    #[ORM\ManyToOne(targetEntity: Couleur::class, inversedBy: 'decoMurales')]
    private $couleur;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupport(): ?string
    {
        return $this->support;
    }

    public function setSupport(string $support): self
    {
        $this->support = $support;

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

    public function getEpaisseur(): ?float
    {
        return $this->epaisseur;
    }

    public function setEpaisseur(?float $epaisseur): self
    {
        $this->epaisseur = $epaisseur;

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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCouleur(): ?Couleur
    {
        return $this->couleur;
    }

    public function setCouleur(?Couleur $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

     
    public function __toString()
    {
        return $this->getStock();
    }
    

}
