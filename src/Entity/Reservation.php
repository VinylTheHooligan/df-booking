<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use DateTimeImmutable;

enum ReservationStatus: string {
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case END = 'end';
    case CANCELLED = 'cancelled';
}

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    #[Assert\DateTime()]
    #[Assert\GreaterThan("now", message: "La réservation doit commencer dans le futur.")]
    #[ORM\Column]
    private ?\DateTimeImmutable $startAt = null;

    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    #[Assert\DateTime()]
    #[Assert\Expression(
    "this.getEndAt() > this.getStartAt()",
    message: "La date de fin doit être postérieure à la date de début."
    )]
    #[ORM\Column]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column]
    #[Assert\DateTime()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(enumType: ReservationStatus::class, length: 50)]
    private ?ReservationStatus $status = ReservationStatus::PENDING;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Resource $resource = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

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

    public function getStatus(): ?ReservationStatus
    {
        return $this->status;
    }

    public function setStatus(ReservationStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    public function setResource(?Resource $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function getDuration(): \DateInterval
    {
        return $this->startAt->diff($this->endAt);
    }
}
