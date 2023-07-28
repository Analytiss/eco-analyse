<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ImpactCategoryTrait
{
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ImpactCategory $impactCategory = null;

    #[ORM\Column(nullable: true)]
    private ?float $value = null;

    public function getImpactCategory(): ?ImpactCategory
    {
        return $this->impactCategory;
    }

    public function setImpactCategory(?ImpactCategory $impactCategory): static
    {
        $this->impactCategory = $impactCategory;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(?float $value): static
    {
        $this->value = $value;

        return $this;
    }
}
