<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $quantity = null;

    /**
     * @var Collection<int, RoomEquipment>
     */
    #[ORM\OneToMany(targetEntity: RoomEquipment::class, mappedBy: 'equipment')]
    private Collection $roomEquipments;

    public function __construct()
    {
        $this->roomEquipments = new ArrayCollection();
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, RoomEquipment>
     */
    public function getRoomEquipments(): Collection
    {
        return $this->roomEquipments;
    }

    public function addRoomEquipments(RoomEquipment $roomEquipments): static
    {
        if (!$this->roomEquipments->contains($roomEquipments)) {
            $this->roomEquipments->add($roomEquipments);
            $roomEquipments->setEquipment($this);
        }

        return $this;
    }

    public function removeRoomEquipments(RoomEquipment $roomEquipments): static
    {
        if ($this->roomEquipments->removeElement($roomEquipments)) {
            // set the owning side to null (unless already changed)
            if ($roomEquipments->getEquipment() === $this) {
                $roomEquipments->setEquipment(null);
            }
        }

        return $this;
    }
}
