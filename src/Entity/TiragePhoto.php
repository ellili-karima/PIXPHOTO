<?php

namespace App\Entity;

use App\Repository\TiragePhotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TiragePhotoRepository::class)]
class TiragePhoto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Tirage::class, inversedBy: 'tiragePhotos')]
    #[ORM\JoinColumn(nullable: false)]
    private $tirage;

    #[ORM\OneToMany(mappedBy: 'tiragePhoto', targetEntity: Photo::class, orphanRemoval: true , cascade:['persist','remove'])]//orphoned c a d si je supprime le parent les enfants serant supprimés ( si je supprime tiragePhoto, les photos seront supprimés)
    private $photos;

    #[ORM\Column(type: 'datetime')]
    private $dateCreation;

    #[ORM\ManyToMany(targetEntity: Option::class,orphanRemoval: true , cascade:['persist'])]
    private $optionsTiragePhoto;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->optionsTiragePhoto = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getTirage(): ?Tirage
    {
        return $this->tirage;
    }

    public function setTirage(?Tirage $tirage): self
    {
        $this->tirage = $tirage;

        return $this;
    }

    public function getQuantiteTirage(): ?int
    {
        return $this->quantiteTirage;
    }

    public function setQuantiteTirage(int $quantiteTirage): self
    {
        $this->quantiteTirage = $quantiteTirage;

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
            $photo->setTiragePhoto($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getTiragePhoto() === $this) {
                $photo->setTiragePhoto(null);
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
        return $this->getPhotos();
    }

    /**
     * si la suppression de la photo existe en retire la photo du dossier tirage
     *
     * @return void
     */
    #[ORM\PostRemove]
    public function deletePhoto(string $photo): void
    {
        // 1. On vérifie que le fichier existe
        if (file_exists(__DIR__.'/../../public/uploads/images/tirage/'. $this->$photo)) {

            // 2. On supprime le fichier
            unlink(__DIR__.'/../../public/uploads/images/tirage/'. $this->$photo);
        }
        // 3. On indique quand utiliser cette méthode grâce aux évènements:
        // #[ORM\HasLifecycleCallbacks]à ajouter sur la class
        // #[ORM\PostRemove] à ajouter sur la méthode qui prend l'évènement

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

    /**
     * @return Collection<int, Option>
     */
    public function getOptionsTiragePhoto(): Collection
    {
        return $this->optionsTiragePhoto;
    }

    public function addOptionsTiragePhoto(Option $optionsTiragePhoto): self
    {
        if (!$this->optionsTiragePhoto->contains($optionsTiragePhoto)) {
            $this->optionsTiragePhoto[] = $optionsTiragePhoto;
        }

        return $this;
    }

    public function removeOptionsTiragePhoto(Option $optionsTiragePhoto): self
    {
        $this->optionsTiragePhoto->removeElement($optionsTiragePhoto);

        return $this;
    }
}
