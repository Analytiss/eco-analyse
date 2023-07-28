<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait EntityTrait
{
    #[ORM\Column(length: 255)]
    #[Groups(['entity_info'])]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    #[Groups(['entity_info', 'impact_category_info'])]
    private ?string $name = null;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
