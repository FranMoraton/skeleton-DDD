<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Domain\Vehicle\Specification;

use Skeleton\Kernel\Domain\Specification\Specification;
use Skeleton\Vehicle\Application\Vehicle\Query\GetVehicleByCriteriaQuery;
use Skeleton\Vehicle\Domain\Vehicle\QueryModel\VehicleByCriteriaQuery;

final class VehicleNameDoesNotExistSpecification implements Specification
{
    /**
     * @var VehicleByCriteriaQuery
     */
    private $vehicleByCriteriaQuery;

    public function __construct(VehicleByCriteriaQuery $vehicleByCriteriaQuery)
    {
        $this->vehicleByCriteriaQuery = $vehicleByCriteriaQuery;
    }

    /**
     * @param VehicleNameDoesNotExistSpecificationObject $object
     * @return bool
     */
    public function isSatisfiedBy($object): bool
    {
        $query = (new GetVehicleByCriteriaQuery())->withName($object->name());

        return empty($this->vehicleByCriteriaQuery->find($query));
    }
}
