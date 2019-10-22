<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Infrastructure\Vehicle\UI\Messaging\Subscribers;

use Skeleton\Kernel\Domain\Event\DomainEvent;
use Skeleton\Kernel\Domain\Event\DomainEventSubscriber;
use Skeleton\Vehicle\Domain\Vehicle\Event\VehicleWasCreated;
use Skeleton\Vehicle\Domain\Vehicle\Model\VehicleRepository;
use Skeleton\Vehicle\Domain\Vehicle\Model\VehicleState;

final class VehicleWasCreatedSubscriber implements DomainEventSubscriber
{
    /**
     * @var VehicleRepository
     */
    private $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @param VehicleWasCreated $aDomainEvent
     */
    public function handle(DomainEvent $aDomainEvent)
    {
        $this->vehicleRepository->add(
            new VehicleState(
                $aDomainEvent->id(),
                $aDomainEvent->name(),
                $aDomainEvent->driver()
            )
        );
    }

    public function hydrate(array $msgData): DomainEvent
    {
        return new VehicleWasCreated(
            $msgData['id'],
            $msgData['name'],
            $msgData['driver'],
        );
    }
}
