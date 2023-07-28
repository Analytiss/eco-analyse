<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: MediaImpactCategory::class, orphanRemoval: true)]
    private Collection $mediaImpactCategories;

    public function __construct()
    {
        $this->mediaImpactCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, MediaImpactCategory>
     */
    public function getMediaImpactCategories(): Collection
    {
        return $this->mediaImpactCategories;
    }

    public function addMediaImpactCategory(MediaImpactCategory $mediaImpactCategory): static
    {
        if (!$this->mediaImpactCategories->contains($mediaImpactCategory)) {
            $this->mediaImpactCategories->add($mediaImpactCategory);
            $mediaImpactCategory->setMedia($this);
        }

        return $this;
    }

    public function removeMediaImpactCategory(MediaImpactCategory $mediaImpactCategory): static
    {
        if ($this->mediaImpactCategories->removeElement($mediaImpactCategory)) {
            // set the owning side to null (unless already changed)
            if ($mediaImpactCategory->getMedia() === $this) {
                $mediaImpactCategory->setMedia(null);
            }
        }

        return $this;
    }
}
