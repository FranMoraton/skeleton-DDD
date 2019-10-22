<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Infrastructure\Vehicle\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Skeleton\Kernel\Infrastructure\Tools\Uuid;
use Skeleton\Vehicle\Domain\Vehicle\Model\VehicleRepository;
use Skeleton\Vehicle\Domain\Vehicle\Model\VehicleState;

final class DoctrineVehicleRepository implements VehicleRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(VehicleState $vehicleState): void
    {
        $this->entityManager->persist($vehicleState);
    }

    public function remove(string $vehicleStateId): void
    {
        $vehicleState = $this->ofId($vehicleStateId);

        if (null !== $vehicleState) {
            $this->entityManager->remove($vehicleState);
        }
    }

    public function update(VehicleState $vehicleState): void
    {
        if (null === $this->ofId($vehicleState->id())) {
            $this->add($vehicleState);
            return;
        }

        $this->entityManager->merge($vehicleState);
    }

    public function ofId(string $vehicleStateId): ?VehicleState
    {
        return $this
            ->entityManager
            ->createQueryBuilder()
            ->select('VehicleState')
            ->from(VehicleState::class, 'VehicleState')
            ->where('VehicleState.id = :$vehicleStateId')
            ->setParameter('vehicleStateId', $vehicleStateId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function nextId(): string
    {
        return Uuid::v4();
    }
}
