<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Domain\Vehicle\QueryModel;

use Skeleton\Vehicle\Application\Vehicle\Query\GetVehicleByCriteriaQuery;

interface VehicleByCriteriaQuery
{
    public function find(GetVehicleByCriteriaQuery $query): array;
}
