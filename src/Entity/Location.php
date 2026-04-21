<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $number = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\Column(length: 5)]
    private ?string $postal = null;

    #[ORM\Column(length: 50)]
    private ?string $city = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $extension = null;

    /**
     * @var Collection<int, Resource>
     */
    #[ORM\OneToMany(targetEntity: Resource::class, mappedBy: 'location')]
    private Collection $resources;

    public function __construct()
    {
        $this->resources = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getPostal(): ?string
    {
        return $this->postal;
    }

    public function setPostal(string $postal): static
    {
        $this->postal = $postal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(?string $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * @return Collection<int, Resource>
     */
    public function getResources(): Collection
    {
        return $this->resources;
    }

    public function addResource(Resource $resource): static
    {
        if (!$this->resources->contains($resource)) {
            $this->resources->add($resource);
            $resource->setLocation($this);
        }

        return $this;
    }

    public function removeResource(Resource $resource): static
    {
        if ($this->resources->removeElement($resource)) {
            // set the owning side to null (unless already changed)
            if ($resource->getLocation() === $this) {
                $resource->setLocation(null);
            }
        }

        return $this;
    }

    public function getAdress(): string
    {
        return $this->number . ' ' . $this->label . ', ' . $this->postal . ' ' . $this->city;
    }
}
