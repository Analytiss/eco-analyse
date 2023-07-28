<?php

namespace App\Entity;

use App\Repository\GasImpactCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GasImpactCategoryRepository::class)]
class GasImpactCategory
{
    use ImpactCategoryTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'gasImpactCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Gas $gas = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGas(): ?Gas
    {
        return $this->gas;
    }

    public function setGas(?Gas $gas): static
    {
        $this->gas = $gas;

        return $this;
    }
}
