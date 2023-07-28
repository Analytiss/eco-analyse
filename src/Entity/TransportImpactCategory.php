<?php

namespace App\Entity;

use App\Repository\TransportImpactCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransportImpactCategoryRepository::class)]
class TransportImpactCategory
{
    use ImpactCategoryTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'impactCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TransportMode $transportMode = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransportMode(): ?TransportMode
    {
        return $this->transportMode;
    }

    public function setTransportMode(?TransportMode $transportMode): static
    {
        $this->transportMode = $transportMode;

        return $this;
    }
}
