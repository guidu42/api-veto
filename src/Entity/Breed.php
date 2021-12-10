<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BreedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BreedRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get']
)]
class Breed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\ManyToOne(targetEntity: Species::class, inversedBy: 'breeds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Species $species;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): self
    {
        $this->species = $species;

        return $this;
    }
}
