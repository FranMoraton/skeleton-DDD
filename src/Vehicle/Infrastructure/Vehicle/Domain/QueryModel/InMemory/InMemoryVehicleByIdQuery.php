<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Infrastructure\Vehicle\Domain\QueryModel\InMemory;

use Skeleton\Vehicle\Domain\Vehicle\QueryModel\VehicleByIdQuery;

final class InMemoryVehicleByIdQuery implements VehicleByIdQuery
{
    private $mock = null;

    public function mockWith(?array $mock): void
    {
        $this->mock = $mock;
    }

    public function find(string $vehicleId): array
    {
        if (null !== $this->mock) {
            return $this->mock;
        }

        return null;
    }
}
