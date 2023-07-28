<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
class Device
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'device', targetEntity: DeviceImpactCategory::class, orphanRemoval: true)]
    private Collection $deviceImpactCategories;

    public function __construct()
    {
        $this->deviceImpactCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, DeviceImpactCategory>
     */
    public function getDeviceImpactCategories(): Collection
    {
        return $this->deviceImpactCategories;
    }

    public function addDeviceImpactCategory(DeviceImpactCategory $deviceImpactCategory): static
    {
        if (!$this->deviceImpactCategories->contains($deviceImpactCategory)) {
            $this->deviceImpactCategories->add($deviceImpactCategory);
            $deviceImpactCategory->setDevice($this);
        }

        return $this;
    }

    public function removeDeviceImpactCategory(DeviceImpactCategory $deviceImpactCategory): static
    {
        if ($this->deviceImpactCategories->removeElement($deviceImpactCategory)) {
            // set the owning side to null (unless already changed)
            if ($deviceImpactCategory->getDevice() === $this) {
                $deviceImpactCategory->setDevice(null);
            }
        }

        return $this;
    }
}
