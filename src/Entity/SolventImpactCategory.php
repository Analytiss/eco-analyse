<?php

namespace App\Entity;

use App\Repository\SolventImpactCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SolventImpactCategoryRepository::class)]
class SolventImpactCategory
{
    use ImpactCategoryTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'solventImpactCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Solvent $solvent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSolvent(): ?Solvent
    {
        return $this->solvent;
    }

    public function setSolvent(?Solvent $solvent): static
    {
        $this->solvent = $solvent;

        return $this;
    }
}
