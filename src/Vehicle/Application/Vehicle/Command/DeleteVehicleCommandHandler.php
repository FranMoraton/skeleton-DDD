<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Application\Vehicle\Command;

use Skeleton\Kernel\Application\Command\CommandHandler;
use Skeleton\Kernel\Domain\Event\EventStream;
use Skeleton\Kernel\Domain\Specification\Specification;
use Skeleton\Vehicle\Domain\Vehicle\Model\DeleteVehicle;
use Skeleton\Vehicle\Domain\Vehicle\Specification\VehicleExistSpecification;

final class DeleteVehicleCommandHandler implements CommandHandler
{
    /**
     * @var VehicleExistSpecification
     */
    private $vehicleExistSpecification;

    public function __construct(Specification $vehicleExistSpecification)
    {
        $this->vehicleExistSpecification = $vehicleExistSpecification;
    }

    public function handle(DeleteVehicleCommand $command = null): EventStream
    {
        return DeleteVehicle::execute(
            $this->vehicleExistSpecification,
            $command
        );
    }
}
