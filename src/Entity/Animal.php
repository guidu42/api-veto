<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ApiResource(
    itemOperations: ['get', 'put', 'delete'],
)]
class Animal
{

    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank, Assert\Length(
        max: 255
    )]
    private ?string $name;

    #[ORM\ManyToOne(targetEntity: Owner::class, inversedBy: 'animals'), ORM\JoinColumn(nullable: true)]
    private ?Owner $owner;

    #[ORM\Column(type: 'string', length: 25, nullable: true)]
    #[Assert\Choice(['m', 'f', 'o'])]
    private ?string $gender;

    #[ORM\ManyToMany(targetEntity: Breed::class)]
    private Collection $breeds;

    public function __construct()
    {
        $this->breeds = new ArrayCollection();
    }

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

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection|Breed[]
     */
    public function getBreeds(): Collection
    {
        return $this->breeds;
    }

    public function addBreed(Breed $breed): self
    {
        if (!$this->breeds->contains($breed)) {
            $this->breeds[] = $breed;
        }

        return $this;
    }

    public function removeBreed(Breed $breed): self
    {
        $this->breeds->removeElement($breed);

        return $this;
    }
}
