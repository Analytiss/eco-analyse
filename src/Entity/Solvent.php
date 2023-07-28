<?php

namespace App\Entity;

use App\Repository\SolventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SolventRepository::class)]
class Solvent
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $extra = null;

    #[ORM\OneToMany(mappedBy: 'solvent', targetEntity: SolventImpactCategory::class, orphanRemoval: true)]
    private Collection $solventImpactCategories;

    public function __construct()
    {
        $this->solventImpactCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isExtra(): ?bool
    {
        return $this->extra;
    }

    public function setExtra(bool $extra): static
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * @return Collection<int, SolventImpactCategory>
     */
    public function getSolventImpactCategories(): Collection
    {
        return $this->solventImpactCategories;
    }

    public function addSolventImpactCategory(SolventImpactCategory $solventImpactCategory): static
    {
        if (!$this->solventImpactCategories->contains($solventImpactCategory)) {
            $this->solventImpactCategories->add($solventImpactCategory);
            $solventImpactCategory->setSolvent($this);
        }

        return $this;
    }

    public function removeSolventImpactCategory(SolventImpactCategory $solventImpactCategory): static
    {
        if ($this->solventImpactCategories->removeElement($solventImpactCategory)) {
            // set the owning side to null (unless already changed)
            if ($solventImpactCategory->getSolvent() === $this) {
                $solventImpactCategory->setSolvent(null);
            }
        }

        return $this;
    }
}
