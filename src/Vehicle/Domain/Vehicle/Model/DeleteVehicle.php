<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Domain\Vehicle\Model;

use Skeleton\Kernel\Domain\Event\EventStream;
use Skeleton\Kernel\Domain\Specification\Specification;
use Skeleton\Vehicle\Application\Vehicle\Command\DeleteVehicleCommand;
use Skeleton\Vehicle\Domain\Vehicle\Event\VehicleWasAlreadyDeleted;
use Skeleton\Vehicle\Domain\Vehicle\Event\VehicleWasDeleted;
use Skeleton\Vehicle\Domain\Vehicle\Specification\VehicleExistSpecification;
use Skeleton\Vehicle\Domain\Vehicle\Specification\VehicleExistSpecificationObject;

final class DeleteVehicle
{
    public static function execute(
        Specification $vehicleExistSpecification,
        DeleteVehicleCommand $command
    ): EventStream {

        $vehicleExistSpecificationObject = new VehicleExistSpecificationObject($command->id());

        if (false === $vehicleExistSpecification->isSatisfiedBy($vehicleExistSpecificationObject)) {
            return EventStream::fromDomainEvents(new VehicleWasAlreadyDeleted($command->id()));
        }

        return EventStream::fromDomainEvents(new VehicleWasDeleted($command->id()));
    }
}
