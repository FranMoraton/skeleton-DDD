<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Application\Vehicle\Command;

use Skeleton\Kernel\Application\Command\CommandHandler;
use Skeleton\Kernel\Domain\Event\EventStream;
use Skeleton\Kernel\Domain\Specification\Specification;
use Skeleton\Vehicle\Domain\Vehicle\Model\VehicleCreator;
use Skeleton\Vehicle\Domain\Vehicle\Model\VehicleRepository;

final class CreateVehicleCommandHandler implements CommandHandler
{
    /**
     * @var Specification
     */
    private $vehicleNameDoesNotExistSpecification;
    /**
     * @var VehicleRepository
     */
    private $vehicleRepository;

    public function __construct(
        VehicleRepository $vehicleRepository,
        Specification $vehicleNameDoesNotExistSpecification)
    {
        $this->vehicleNameDoesNotExistSpecification = $vehicleNameDoesNotExistSpecification;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function handle(CreateVehicleCommand $command = null): EventStream
    {
        return VehicleCreator::execute(
            $this->vehicleRepository,
            $this->vehicleNameDoesNotExistSpecification,
            $command
        );
    }
}
