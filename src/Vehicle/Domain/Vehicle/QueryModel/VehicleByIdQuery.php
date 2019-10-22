<?php

namespace Skeleton\Vehicle\Domain\Vehicle\QueryModel;

interface VehicleByIdQuery
{
    public function find(string $vehicleStateId): array;
}
