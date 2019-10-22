<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Application\Vehicle\Query;

use Skeleton\Kernel\Application\Query\QueryHandler;
use Skeleton\Vehicle\Domain\Vehicle\QueryModel\VehicleByCriteriaQuery;

final class GetVehicleByCriteriaQueryHandler implements QueryHandler
{
    /**
     * @var VehicleByCriteriaQuery
     */
    private $vehicleByCriteriaQuery;

    public function __construct(VehicleByCriteriaQuery $vehicleByCriteriaQuery)
    {
        $this->vehicleByCriteriaQuery = $vehicleByCriteriaQuery;
    }

    public function handle(GetVehicleByCriteriaQuery $query = null)
    {
        return $this->vehicleByCriteriaQuery->find($query);
    }
}
