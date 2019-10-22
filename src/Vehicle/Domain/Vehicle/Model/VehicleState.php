<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Domain\Vehicle\Model;

class VehicleState
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $driver;
    /**
     * @var string|null
     */
    private $latitude;
    /**
     * @var string|null
     */
    private $longitude;

    public function __construct(string $id, string $name, string $driver)
    {
        $this->id = $id;
        $this->name = $name;
        $this->driver = $driver;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function withId(string $id): self
    {
        $clone = clone $this;
        $clone->id = $id;
        return $clone;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function withName(string $name): self
    {
        $clone = clone $this;
        $clone->name = $name;
        return $clone;
    }

    public function driver(): string
    {
        return $this->driver;
    }

    public function withDriver(string $driver): self
    {
        $clone = clone $this;
        $clone->driver = $driver;
        return $clone;
    }

    public function latitude(): ?string
    {
        return $this->latitude;
    }

    public function withLatitude(?string $latitude): self
    {
        $clone = clone $this;
        $clone->latitude = $latitude;
        return $clone;
    }

    public function longitude(): ?string
    {
        return $this->longitude;
    }

    public function withLongitude(?string $longitude): self
    {
        $clone = clone $this;
        $clone->longitude = $longitude;
        return $clone;
    }
}
