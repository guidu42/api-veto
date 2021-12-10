<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\SpeciesRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SpeciesRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    attributes: [
        'pagination_items_per_page' => 10,
    ],
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['name', 'id'])]
#[ApiFilter(DateFilter::class, properties: ['discoveredSince'])]
class Species
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank, Assert\Length(
        max: 255
    )]
    private ?string $name;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\Type(DateTimeInterface::class)]
    private ?DateTimeInterface $discoveredSince;

    #[ORM\OneToMany(mappedBy: 'species', targetEntity: Breed::class, orphanRemoval: true)]
    #[ApiSubresource] // pose une relation en subressource dans l'api. On pourra accéder aux breeds de cette espece via le lien /api/species/id/breeds
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

    public function getDiscoveredSince(): ?DateTimeInterface
    {
        return $this->discoveredSince;
    }

    public function setDiscoveredSince(?DateTimeInterface $discoveredSince): self
    {
        $this->discoveredSince = $discoveredSince;

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
            $breed->setSpecies($this);
        }

        return $this;
    }

    public function removeBreed(Breed $breed): self
    {
        if ($this->breeds->removeElement($breed)) {
            // set the owning side to null (unless already changed)
            if ($breed->getSpecies() === $this) {
                $breed->setSpecies(null);
            }
        }

        return $this;
    }
}
