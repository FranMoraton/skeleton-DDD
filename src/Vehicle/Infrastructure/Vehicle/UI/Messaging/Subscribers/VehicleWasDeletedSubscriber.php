<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Infrastructure\Vehicle\UI\Messaging\Subscribers;

use Skeleton\Kernel\Domain\Event\DomainEvent;
use Skeleton\Kernel\Domain\Event\DomainEventSubscriber;
use Skeleton\Vehicle\Domain\Vehicle\Event\VehicleWasDeleted;
use Skeleton\Vehicle\Domain\Vehicle\Model\VehicleRepository;

final class VehicleWasDeletedSubscriber implements DomainEventSubscriber
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
     * @param VehicleWasDeleted $aDomainEvent
     */
    public function handle(DomainEvent $aDomainEvent)
    {
        $this->vehicleRepository->remove($aDomainEvent->id());
    }

    public function hydrate(array $msgData): DomainEvent
    {
        return new VehicleWasDeleted(
            $msgData['id']
        );
    }
}
