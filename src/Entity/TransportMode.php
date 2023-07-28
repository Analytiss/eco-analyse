<?php

namespace App\Entity;

use App\Repository\TransportModeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransportModeRepository::class)]
class TransportMode
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'transportMode', targetEntity: TransportImpactCategory::class, orphanRemoval: true)]
    private Collection $impactCategories;

    public function __construct()
    {
        $this->impactCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, TransportImpactCategory>
     */
    public function getImpactCategories(): Collection
    {
        return $this->impactCategories;
    }

    public function addImpactCategory(TransportImpactCategory $impactCategory): static
    {
        if (!$this->impactCategories->contains($impactCategory)) {
            $this->impactCategories->add($impactCategory);
            $impactCategory->setTransportMode($this);
        }

        return $this;
    }

    public function removeImpactCategory(TransportImpactCategory $impactCategory): static
    {
        if ($this->impactCategories->removeElement($impactCategory)) {
            // set the owning side to null (unless already changed)
            if ($impactCategory->getTransportMode() === $this) {
                $impactCategory->setTransportMode(null);
            }
        }

        return $this;
    }
}
