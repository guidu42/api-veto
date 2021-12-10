<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OwnerRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OwnerRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            'denormalization_context' => [
                'groups' => ['owner_creation']
            ]
        ]
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['full_owner']
            ]
        ],
        'put',
        'delete',
        'patch'
    ],
    attributes: [
        'pagination_items_per_page' => 50,
    ],
    denormalizationContext: [
        'groups' => ['full_owner']
    ],
    normalizationContext: [
        'groups' => ['lite_owner'],
    ]
)]
class Owner
{

    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    #[Groups(['full_owner', 'lite_owner'])]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank, Assert\Length(
        max: 255
    )]
    #[Groups(['full_owner', 'lite_owner', 'owner_creation'])]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank, Assert\Length(
        max: 255
    )]
    #[Groups(['full_owner', 'lite_owner', 'owner_creation'])]
    private string $lastName;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\Type(DateTimeInterface::class)]
    #[Groups(['full_owner'])]
    private DateTimeInterface $birthDate;

    #[ORM\OneToMany(mappedBy: "owner", targetEntity: Animal::class, orphanRemoval: true)]
    private Collection $animals;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return Collection|Animal[]
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals[] = $animal;
            $animal->setOwner($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getOwner() === $this) {
                $animal->setOwner(null);
            }
        }

        return $this;
    }
}
