<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Domain\Vehicle\Specification;

use Skeleton\Kernel\Domain\Specification\Specification;
use Skeleton\Vehicle\Domain\Vehicle\QueryModel\VehicleByIdQuery;

final class VehicleExistSpecification implements Specification
{
    /**
     * @var VehicleByIdQuery
     */
    private $vehicleByIdQuery;

    public function __construct(VehicleByIdQuery $vehicleByIdQuery)
    {
        $this->vehicleByIdQuery = $vehicleByIdQuery;
    }

    /**
     * @param VehicleExistSpecificationObject $object
     * @return bool
     */
    public function isSatisfiedBy($object): bool
    {
        return false === empty($this->vehicleByIdQuery->find($object->id()));
    }
}
