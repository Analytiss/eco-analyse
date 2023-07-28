<?php

namespace App\Entity;

use App\Repository\ConsumableImpactCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsumableImpactCategoryRepository::class)]
class ConsumableImpactCategory
{
    use ImpactCategoryTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'consumableImpactCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Consumable $consumable = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConsumable(): ?Consumable
    {
        return $this->consumable;
    }

    public function setConsumable(?Consumable $consumable): static
    {
        $this->consumable = $consumable;

        return $this;
    }
}
