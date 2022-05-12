<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ApiResource(
    collectionOperations:[
        'get',
        'post' => ["security" => "is_granted('ROLE_ADMIN_ANIMAL')"]
    ],
    itemOperations: [
        'get',
        'put' => ["security" => "is_granted('ROLE_ADMIN_ANIMAL')"],
        'delete' => ["security" => "is_granted('ROLE_ADMIN_ANIMAL')"]
    ],
)]
#[ApiFilter(ExistsFilter::class, properties: ['owner'])]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial', 'gender', 'breeds' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['id', 'owner','gender', 'breeds'])]
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

    #[ORM\ManyToOne(targetEntity: Species::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Species $species;

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
