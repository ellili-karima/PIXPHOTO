<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PhotoRepository;
use Vich\UploaderBundle\Entity\File;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 40)]
    private $photo;

   
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: TiragePhoto::class, inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private $tiragePhoto;

    #[ORM\OneToMany(mappedBy: 'photo', targetEntity: DecoMuralePhoto::class)]
    private $decoMuralePhotos;

    #[ORM\OneToMany(mappedBy: 'photo', targetEntity: DecoMuralePhoto::class)]
    private $k;

    #[ORM\ManyToOne(targetEntity: DecoMuralePhoto::class, inversedBy: 'photo')]
    private $decoMuralePhoto;


    public function __construct()
    {
        $this->decoMuralePhotos = new ArrayCollection();
        $this->k = new ArrayCollection();
    }

   

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string|File $photo): self
    {
        $this->photo = $photo;

        return $this;
    }



    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTiragePhoto(): ?TiragePhoto
    {
        return $this->tiragePhoto;
    }

    public function setTiragePhoto(?TiragePhoto $tiragePhoto): self
    {
        $this->tiragePhoto = $tiragePhoto;

        return $this;
    }

    /**
     * @return Collection<int, DecoMuralePhoto>
     */
    public function getDecoMuralePhotos(): Collection
    {
        return $this->decoMuralePhotos;
    }

    public function addDecoMuralePhoto(DecoMuralePhoto $decoMuralePhoto): self
    {
        if (!$this->decoMuralePhotos->contains($decoMuralePhoto)) {
            $this->decoMuralePhotos[] = $decoMuralePhoto;
            $decoMuralePhoto->setPhoto($this);
        }

        return $this;
    }

    public function removeDecoMuralePhoto(DecoMuralePhoto $decoMuralePhoto): self
    {
        if ($this->decoMuralePhotos->removeElement($decoMuralePhoto)) {
            // set the owning side to null (unless already changed)
            if ($decoMuralePhoto->getPhoto() === $this) {
                $decoMuralePhoto->setPhoto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DecoMuralePhoto>
     */
    public function getK(): Collection
    {
        return $this->k;
    }

    public function addK(DecoMuralePhoto $k): self
    {
        if (!$this->k->contains($k)) {
            $this->k[] = $k;
            $k->setPhoto($this);
        }

        return $this;
    }

    public function removeK(DecoMuralePhoto $k): self
    {
        if ($this->k->removeElement($k)) {
            // set the owning side to null (unless already changed)
            if ($k->getPhoto() === $this) {
                $k->setPhoto(null);
            }
        }

        return $this;
    }

    public function getDecoMuralePhoto(): ?DecoMuralePhoto
    {
        return $this->decoMuralePhoto;
    }

    public function setDecoMuralePhoto(?DecoMuralePhoto $decoMuralePhoto): self
    {
        $this->decoMuralePhoto = $decoMuralePhoto;

        return $this;
    }

   

}
