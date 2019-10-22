<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Infrastructure\Vehicle\Domain\QueryModel\Doctrine;


use Doctrine\DBAL\Connection;
use Skeleton\Vehicle\Application\Vehicle\Query\GetVehicleByCriteriaQuery;
use Skeleton\Vehicle\Domain\Vehicle\QueryModel\VehicleByCriteriaQuery;

final class DoctrineVehicleByCriteriaQuery implements VehicleByCriteriaQuery
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(GetVehicleByCriteriaQuery $query): array
    {
        $qb = $this->connection->createQueryBuilder()
            ->select('name')
            ->from('vehicle', 'vehicle');

            if (null !==$query->name()) {
                $qb->andWhere('vehicle.name = :queryName')
                    ->setParameter('queryName', $query->name());
            }

        return $qb->execute()->fetchAll();
    }
}
