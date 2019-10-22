<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Infrastructure\Vehicle\Domain\QueryModel\InMemory;

use Skeleton\Vehicle\Application\Vehicle\Query\GetVehicleByCriteriaQuery;
use Skeleton\Vehicle\Domain\Vehicle\QueryModel\VehicleByCriteriaQuery;

final class InMemoryVehicleByCriteriaQuery implements VehicleByCriteriaQuery
{
    private $mock = null;

    public function mockWith(?array $mock): void
    {
        $this->mock = $mock;
    }

    public function find(GetVehicleByCriteriaQuery $query): array
    {
        if (null !== $this->mock) {
            return $this->mock;
        }

        return [];
    }
}
