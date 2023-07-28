<?php

namespace App\Entity;

use App\Repository\GasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GasRepository::class)]
class Gas
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'gas', targetEntity: GasImpactCategory::class, orphanRemoval: true)]
    private Collection $gasImpactCategories;

    public function __construct()
    {
        $this->gasImpactCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, GasImpactCategory>
     */
    public function getGasImpactCategories(): Collection
    {
        return $this->gasImpactCategories;
    }

    public function addGasImpactCategory(GasImpactCategory $gasImpactCategory): static
    {
        if (!$this->gasImpactCategories->contains($gasImpactCategory)) {
            $this->gasImpactCategories->add($gasImpactCategory);
            $gasImpactCategory->setGas($this);
        }

        return $this;
    }

    public function removeGasImpactCategory(GasImpactCategory $gasImpactCategory): static
    {
        if ($this->gasImpactCategories->removeElement($gasImpactCategory)) {
            // set the owning side to null (unless already changed)
            if ($gasImpactCategory->getGas() === $this) {
                $gasImpactCategory->setGas(null);
            }
        }

        return $this;
    }
}
