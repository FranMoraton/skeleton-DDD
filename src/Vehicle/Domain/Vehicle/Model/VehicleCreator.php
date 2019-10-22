<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Domain\Vehicle\Model;

use Skeleton\Kernel\Domain\Event\EventStream;
use Skeleton\Kernel\Domain\Specification\Specification;
use Skeleton\Vehicle\Application\Vehicle\Command\CreateVehicleCommand;
use Skeleton\Vehicle\Domain\Vehicle\Event\VehicleCreatorFailed;
use Skeleton\Vehicle\Domain\Vehicle\Event\VehicleWasCreated;
use Skeleton\Vehicle\Domain\Vehicle\Specification\VehicleNameDoesNotExistSpecificationObject;

final class VehicleCreator
{
    public static function execute(
        VehicleRepository $vehicleRepository,
        Specification $vehicleNameDoesNotExistSpecification,
        CreateVehicleCommand $command
    ): EventStream {
        $events = [];

        $vehicleNameDoesNotExistSpecificationObject = new VehicleNameDoesNotExistSpecificationObject($command->name());
        if (false === $vehicleNameDoesNotExistSpecification->isSatisfiedBy($vehicleNameDoesNotExistSpecificationObject)) {
            $events [] = new VehicleCreatorFailed(
                VehicleCreatorFailed::NAME_WAS_IN_USE,
                $command->name(),
                $command->driver()
            );
        }

        if (false === empty($events)) {
            return EventStream::fromDomainEvents(...$events);
        }

        return EventStream::fromDomainEvents(
            new VehicleWasCreated(
                $vehicleRepository->nextId(),
                $command->name(),
                $command->driver()
            )
        );
    }
}
