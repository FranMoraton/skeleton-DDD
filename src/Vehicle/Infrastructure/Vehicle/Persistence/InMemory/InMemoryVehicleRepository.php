<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Infrastructure\Vehicle\Persistence\InMemory;

use Skeleton\Kernel\Infrastructure\Tools\Uuid;
use Skeleton\Vehicle\Domain\Vehicle\Model\VehicleRepository;
use Skeleton\Vehicle\Domain\Vehicle\Model\VehicleState;

final class InMemoryVehicleRepository implements VehicleRepository
{
    private $items = [];

    private $mock;

    private $spy = false;

    public function spyWasCalled(): bool
    {
        return $this->spy;
    }

    public function mockNextid(string $nextId): void
    {
        $this->mock = $nextId;
    }

    public function add(VehicleState $vehicleState): void
    {
        $this->spy = true;
    }

    public function remove(string $vehicleStateId): void
    {
        $this->spy = true;
    }

    public function update(VehicleState $vehicleState): void
    {
        // TODO: Implement update() method.
    }

    public function ofId(string $vehicleStateId): ?VehicleState
    {
        // TODO: Implement ofId() method.
    }

    public function nextId(): string
    {
        return $this->mock ?? Uuid::v4();
    }
}
