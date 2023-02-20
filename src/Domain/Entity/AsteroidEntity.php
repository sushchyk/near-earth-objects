<?php

namespace Neo\Domain\Entity;

class AsteroidEntity
{
    private int $id;
    private string $name;
    private string $referenceId;
    private \DateTimeImmutable $date;
    private float $speed;
    private bool $isHazardous;

    public function __construct(
        string $name,
        string $referenceId,
        \DateTimeImmutable $date,
        float $speed,
        bool $isHazardous
    ) {
        $this->name = $name;
        $this->referenceId = $referenceId;
        $this->date = $date;
        $this->speed = $speed;
        $this->isHazardous = $isHazardous;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReferenceId(): string
    {
        return $this->referenceId;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getSpeed(): float
    {
        return $this->speed;
    }

    public function isHazardous(): bool
    {
        return $this->isHazardous;
    }
}
