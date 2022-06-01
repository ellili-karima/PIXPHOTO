<?php

namespace App\Entity;

use App\Entity\DecoMurale;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TiragePhotoRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: TiragePhotoRepository::class)]
class DecoMuralePhoto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: DecoMurale::class, inversedBy: 'tiragePhotos')]
    #[ORM\JoinColumn(nullable: false)]
    private $decoMurale;

    #[ORM\Column(type: 'integer')]
    private $quantiteDeco;

    #[ORM\OneToMany(mappedBy: 'decoMuralePhoto', targetEntity: Photo::class, orphanRemoval: true , cascade:['persist','remove'])]//orphoned c a d si je supprime le parent les enfants serant supprimés ( si je supprime tiragePhoto, les photos seront supprimés)
    private $photos;

    #[ORM\Column(type: 'datetime')]
    private $dateCreation;

    
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
     * Get the value of quantiteDeco
     */ 
    public function getQuantiteDeco()
    {
        return $this->quantiteDeco;
    }

    /**
     * Set the value of quantiteDeco
     *
     * @return  self
     */ 
    public function setQuantiteDeco($quantiteDeco)
    {
        $this->quantiteDeco = $quantiteDeco;

        return $this;
    }

    /**
     * Get the value of photos
     */ 
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set the value of photos
     *
     * @return  self
     */ 
    public function setPhotos($photos)
    {
        $this->photos = $photos;

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
}
