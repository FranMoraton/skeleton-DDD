<?php

namespace Skeleton\Vehicle\Domain\Vehicle\Model;

interface VehicleRepository
{
    public function add(VehicleState $vehicleState): void;
    public function remove(string $vehicleStateId): void;
    public function update(VehicleState $vehicleState): void;
    public function ofId(string $vehicleStateId): ?VehicleState;
    public function nextId(): string;
}
