<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Infrastructure\Vehicle\Domain\QueryModel\Doctrine;

use Doctrine\DBAL\Connection;
use Skeleton\Vehicle\Domain\Vehicle\QueryModel\VehicleByIdQuery;

final class DoctrineVehicleByIdQuery implements VehicleByIdQuery
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(string $vehicleStateId): array
    {
        $result = $this->connection->createQueryBuilder()
            ->select('vehicle')
            ->from('vehicle', 'vehicle')
            ->where('vehicle.name = :queryName')
            ->setParameter('queryName', $vehicleStateId)
            ->execute()->fetch();

        return false !== $result ? $result : [] ;
    }
}
