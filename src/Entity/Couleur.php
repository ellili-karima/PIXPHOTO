<?php

namespace App\Entity;

use App\Repository\CouleurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouleurRepository::class)]
class Couleur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    private $couleur;

    #[ORM\OneToMany(mappedBy: 'couleur', targetEntity: DecoMurale::class)]
    private $decoMurales;

    public function __construct()
    {
        $this->decoMurales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * @return Collection<int, DecoMurale>
     */
    public function getDecoMurales(): Collection
    {
        return $this->decoMurales;
    }

    public function addDecoMurale(DecoMurale $decoMurale): self
    {
        if (!$this->decoMurales->contains($decoMurale)) {
            $this->decoMurales[] = $decoMurale;
            $decoMurale->setCouleur($this);
        }

        return $this;
    }

    public function removeDecoMurale(DecoMurale $decoMurale): self
    {
        if ($this->decoMurales->removeElement($decoMurale)) {
            // set the owning side to null (unless already changed)
            if ($decoMurale->getCouleur() === $this) {
                $decoMurale->setCouleur(null);
            }
        }

        return $this;
    }

 
    /**
     * convertir les photos en chaine des caracteres
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getCouleur();
    }
}
