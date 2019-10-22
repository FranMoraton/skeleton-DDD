<?php

declare(strict_types=1);

namespace Skeleton\Tests\Vehicle\Application\Vehicle\Command;

use Skeleton\Kernel\Infrastructure\Tools\Uuid;
use Skeleton\Tests\Kernel\Application\CommandHandlerScenarioTestCase;
use Skeleton\Tests\Kernel\Domain\Specification\FailureSpecification;
use Skeleton\Tests\Kernel\Domain\Specification\SuccessSpecification;
use Skeleton\Vehicle\Application\Vehicle\Command\DeleteVehicleCommand;
use Skeleton\Vehicle\Application\Vehicle\Command\DeleteVehicleCommandHandler;
use Skeleton\Vehicle\Domain\Vehicle\Event\VehicleWasAlreadyDeleted;
use Skeleton\Vehicle\Domain\Vehicle\Event\VehicleWasDeleted;

final class DeleteVehicleCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    /**
     * @test
     */
    public function givenDeleteVehicleCommandWhenDoesNotExistThenAlreadyDeleted(): void
    {
        $commandHandler = new DeleteVehicleCommandHandler(
            $vehicleExistSpecification = new FailureSpecification()
        );

        $command = new DeleteVehicleCommand(
            $id = Uuid::v4()
        );

        $expectedEvent = new VehicleWasAlreadyDeleted(
            $id
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
    public function givenDeleteVehicleCommandWhenDoesNotExistThenVehicleWasDeleted(): void
    {
        $commandHandler = new DeleteVehicleCommandHandler(
            $vehicleExistSpecification = new SuccessSpecification()
        );

        $command = new DeleteVehicleCommand(
            $id = Uuid::v4()
        );

        $expectedEvent = new VehicleWasDeleted(
            $id
        );

        $this
            ->scenario
            ->withCommandHandler($commandHandler)
            ->when($command)
            ->then($expectedEvent);
    }
}
