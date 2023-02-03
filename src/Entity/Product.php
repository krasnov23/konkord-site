<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
//    #[Assert\File(
//        maxSize: '1024k',
//        mimeTypes: ['image/jpeg','image/png'],
//        mimeTypesMessage: 'Please upload a valid PDF',
//    )]
    private ?string $mainPagePhoto = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo3 = null;

    #[ORM\Column(length: 2500, nullable: true)]
    private ?string $description1 = null;

    #[ORM\Column(length: 2500, nullable: true)]
    private ?string $description2 = null;

    #[ORM\Column(length: 2500, nullable: true)]
    private ?string $description3 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMainPagePhoto(): ?string
    {
        return $this->mainPagePhoto;
    }

    public function setMainPagePhoto(?string $mainPagePhoto): self
    {
        $this->mainPagePhoto = $mainPagePhoto;

        return $this;
    }

    public function getSubtitle1(): ?string
    {
        return $this->subtitle1;
    }

    public function setSubtitle1(?string $subtitle1): self
    {
        $this->subtitle1 = $subtitle1;

        return $this;
    }

    public function getSubtitle2(): ?string
    {
        return $this->subtitle2;
    }

    public function setSubtitle2(?string $subtitle2): self
    {
        $this->subtitle2 = $subtitle2;

        return $this;
    }

    public function getSubtitle3(): ?string
    {
        return $this->subtitle3;
    }

    public function setSubtitle3(?string $subtitle3): self
    {
        $this->subtitle3 = $subtitle3;

        return $this;
    }

    public function getPhoto1(): ?string
    {
        return $this->photo1;
    }

    public function setPhoto1(?string $photo1): self
    {
        $this->photo1 = $photo1;

        return $this;
    }

    public function getPhoto2(): ?string
    {
        return $this->photo2;
    }

    public function setPhoto2(?string $photo2): self
    {
        $this->photo2 = $photo2;

        return $this;
    }

    public function getPhoto3(): ?string
    {
        return $this->photo3;
    }

    public function setPhoto3(?string $photo3): self
    {
        $this->photo3 = $photo3;

        return $this;
    }

    public function getDescription1(): ?string
    {
        return $this->description1;
    }

    public function setDescription1(?string $description1): self
    {
        $this->description1 = $description1;

        return $this;
    }

    public function getDescription2(): ?string
    {
        return $this->description2;
    }

    public function setDescription2(?string $description2): self
    {
        $this->description2 = $description2;

        return $this;
    }

    public function getDescription3(): ?string
    {
        return $this->description3;
    }

    public function setDescription3(?string $description3): self
    {
        $this->description3 = $description3;

        return $this;
    }
}
