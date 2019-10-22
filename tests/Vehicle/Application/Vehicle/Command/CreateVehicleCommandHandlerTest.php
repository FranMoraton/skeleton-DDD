<?php

declare(strict_types=1);

namespace Skeleton\Tests\Vehicle\Application\Vehicle\Command;

use Skeleton\Kernel\Infrastructure\Tools\Uuid;
use Skeleton\Tests\Kernel\Application\CommandHandlerScenarioTestCase;
use Skeleton\Tests\Kernel\Domain\Specification\FailureSpecification;
use Skeleton\Tests\Kernel\Domain\Specification\SuccessSpecification;
use Skeleton\Vehicle\Application\Vehicle\Command\CreateVehicleCommand;
use Skeleton\Vehicle\Application\Vehicle\Command\CreateVehicleCommandHandler;
use Skeleton\Vehicle\Domain\Vehicle\Event\VehicleCreatorFailed;
use Skeleton\Vehicle\Domain\Vehicle\Event\VehicleWasCreated;
use Skeleton\Vehicle\Infrastructure\Vehicle\Persistence\InMemory\InMemoryVehicleRepository;

final class CreateVehicleCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    /**
     * @var InMemoryVehicleRepository
     */
    private $inMemoryRepository;

    public function setUp(): void
    {
        $this->inMemoryRepository = new InMemoryVehicleRepository();
    }

    /**
     * @test
     */
    public function givenCreateVehicleCommandWhenNameAlreadyRegisteredThenFail(): void
    {
        $commandHandler = new CreateVehicleCommandHandler(
            $this->inMemoryRepository,
            $vehicleNameDoesNotExistSpecification = new FailureSpecification()
        );

        $command = new CreateVehicleCommand(
            $name = 'name',
            $driver = 'driver'
        );

        $expectedEvent = new VehicleCreatorFailed(
            VehicleCreatorFailed::NAME_WAS_IN_USE,
            $name,
            $driver
        );

        $this
            ->scenario
            ->withCommandHandler($commandHandler)
            ->when($command)
            ->then($expectedEvent);
    }

    /**
     * @test
     */
    public function givenCreateVehicleCommandWhenNameNotRegisteredThenSuccess(): void
    {
        $this->inMemoryRepository->mockNextid($nextId = Uuid::v4());

        $commandHandler = new CreateVehicleCommandHandler(
            $this->inMemoryRepository,
            $vehicleNameDoesNotExistSpecification = new SuccessSpecification()
        );

        $command = new CreateVehicleCommand(
            $name = 'name',
            $driver = 'driver'
        );

        $expectedEvent = new VehicleWasCreated(
            $nextId,
            $name,
            $driver
        );

        $this
            ->scenario
            ->withCommandHandler($commandHandler)
            ->when($command)
            ->then($expectedEvent);
    }
}
