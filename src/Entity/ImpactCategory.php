<?php

namespace App\Entity;

use App\Repository\ImpactCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ImpactCategoryRepository::class)]
class ImpactCategory
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['impact_category_info'])]
    private ?string $unit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameFR = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getNameFR(): ?string
    {
        return $this->nameFR;
    }

    public function setNameFR(?string $nameFR): static
    {
        $this->nameFR = $nameFR;

        return $this;
    }
}
