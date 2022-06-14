<?php

namespace App\Entity;

use App\Entity\Couleur;
use App\Entity\DecoMurale;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\DecoMuralePhotoRepository;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: DecoMuralePhotoRepository::class)]
class DecoMuralePhoto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: DecoMurale::class, inversedBy: 'decoMuralePhotos')]
    #[ORM\JoinColumn(nullable: false)]
    private $decoMurale;

    #[ORM\OneToMany(mappedBy: 'decoMuralePhoto', targetEntity: Photo::class, orphanRemoval: true , cascade:['persist','remove'])]//orphoned c a d si je supprime le parent les enfants serant supprimés ( si je supprime decoMuralePhoto, les photos seront supprimés)
    private $photos;

    #[ORM\Column(type: 'datetime')]
    private $dateCreation;

    #[ORM\ManyToOne(targetEntity: Impression::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $impression;

    #[ORM\ManyToOne(targetEntity: Couleur::class)]
    private $couleur;

    
    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of decoMurale
     */ 
    public function getDecoMurale()
    {
        return $this->decoMurale;
    }

    /**
     * Set the value of decoMurale
     *
     * @return  self
     */ 
    public function setDecoMurale($decoMurale)
    {
        $this->decoMurale = $decoMurale;

        return $this;
    }

    
    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setDecoMuralePhoto($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getDecoMuralePhoto() === $this) {
                $photo->setDecoMuralePhoto(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of dateCreation
     */ 
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set the value of dateCreation
     *
     * @return  self
     */ 
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getImpression(): ?Impression
    {
        return $this->impression;
    }

    public function setImpression(?Impression $impression): self
    {
        $this->impression = $impression;

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

   
}
