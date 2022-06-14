<?php

namespace App\Entity;

use App\Entity\DecoMuralePhoto;
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
    #[ORM\JoinColumn(nullable: true)]
    private $tiragePhoto;

    #[ORM\ManyToOne(targetEntity: DecoMuralePhoto::class, inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: true)]
    private $decoMuralePhoto;

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
