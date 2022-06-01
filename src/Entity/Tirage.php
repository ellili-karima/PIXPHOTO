<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TirageRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: TirageRepository::class)]
class Tirage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $tirage;

    #[ORM\Column(type: 'string', length: 20)]
    private $format;

    #[ORM\Column(type: 'float')]
    private $prix;

    #[ORM\Column(type: 'integer')]
    private $quantite;


    #[ORM\OneToMany(mappedBy: 'tirage', targetEntity: TiragePhoto::class)]
    private $tiragePhotos;

    public function __construct()
    {
        $this->tiragePhotos = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTirage(): ?string
    {
        return $this->tirage;
    }

    public function setTirage(string $tirage): self
    {
        $this->tirage = $tirage;

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
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }


    /**
     * @return Collection<int, TiragePhoto>
     */
    public function getTiragePhotos(): Collection
    {
        return $this->tiragePhotos;
    }

    public function addTiragePhoto(TiragePhoto $tiragePhoto): self
    {
        if (!$this->tiragePhotos->contains($tiragePhoto)) {
            $this->tiragePhotos[] = $tiragePhoto;
            $tiragePhoto->setTirage($this);
        }

        return $this;
    }

    public function removeTiragePhoto(TiragePhoto $tiragePhoto): self
    {
        if ($this->tiragePhotos->removeElement($tiragePhoto)) {
            // set the owning side to null (unless already changed)
            if ($tiragePhoto->getTirage() === $this) {
                $tiragePhoto->setTirage(null);
            }
        }

        return $this;
    }

    

}
