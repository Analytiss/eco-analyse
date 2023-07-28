<?php

namespace App\Entity;

use App\Repository\ConsumableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsumableRepository::class)]
class Consumable
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'consumable', targetEntity: ConsumableImpactCategory::class, orphanRemoval: true)]
    private Collection $consumableImpactCategories;

    public function __construct()
    {
        $this->consumableImpactCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ConsumableImpactCategory>
     */
    public function getConsumableImpactCategories(): Collection
    {
        return $this->consumableImpactCategories;
    }

    public function addConsumableImpactCategory(ConsumableImpactCategory $consumableImpactCategory): static
    {
        if (!$this->consumableImpactCategories->contains($consumableImpactCategory)) {
            $this->consumableImpactCategories->add($consumableImpactCategory);
            $consumableImpactCategory->setConsumable($this);
        }

        return $this;
    }

    public function removeConsumableImpactCategory(ConsumableImpactCategory $consumableImpactCategory): static
    {
        if ($this->consumableImpactCategories->removeElement($consumableImpactCategory)) {
            // set the owning side to null (unless already changed)
            if ($consumableImpactCategory->getConsumable() === $this) {
                $consumableImpactCategory->setConsumable(null);
            }
        }

        return $this;
    }
}
