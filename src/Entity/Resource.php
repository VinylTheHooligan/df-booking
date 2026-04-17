<?php

namespace App\Entity;

use App\Repository\ResourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResourceRepository::class)]
class Resource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 100)]
    private ?string $location = null;

    #[ORM\Column]
    private ?int $capacity;

    #[ORM\Column]
    private ?bool $isEnabled = true;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(fetch: 'LAZY', inversedBy: 'resources')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ResourceType $resourceType = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'resource')]
    private Collection $reservations;

    /**
     * @var Collection<int, RoomEquipment>
     */
    #[ORM\OneToMany(targetEntity: RoomEquipment::class, mappedBy: 'resource', orphanRemoval: true)]
    private Collection $equipments;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->equipments = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): static
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getResourceType(): ?ResourceType
    {
        return $this->resourceType;
    }

    public function setResourceType(?ResourceType $resourceType): static
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setResource($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getResource() === $this) {
                $reservation->setResource(null);
            }
        }

        return $this;
    }

    public function isFreeAt(\DateTimeImmutable $date): bool
    {
        foreach ($this->reservations as $r)
        {
            if ($r->getStartAt() <= $date && $r->getEndAt() >= $date)
            {
                return false;
            }
        }
        return true;
    }

    public function isAvailableForSlot(\DateTimeImmutable $start, \DateTimeImmutable $end): bool
    {
        if (!$this->isEnabled)
        {
            return false;
        }

        foreach ($this->reservations as $reservation)
        {
            $overlap = $reservation->getStartAt() < $end && $reservation->getEndAt() > $start;

            if ($overlap)
            {
                return false;
            }
        }
        return true;
    }

    /**
     * @return Collection<int, RoomEquipment>
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(RoomEquipment $equipment): static
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments->add($equipment);
            $equipment->setResource($this);
        }

        return $this;
    }

    public function removeEquipment(RoomEquipment $equipment): static
    {
        if ($this->equipments->removeElement($equipment)) {
            // set the owning side to null (unless already changed)
            if ($equipment->getResource() === $this) {
                $equipment->setResource(null);
            }
        }

        return $this;
    }
}