<?php
declare(strict_types=1);

namespace Skeleton\Tests\BasketTeam\Application\BasketTeam\Command;

use Skeleton\BasketTeam\Application\BasketTeam\Command\RemoveBasketTeamPlayerCommand;
use Skeleton\BasketTeam\Application\BasketTeam\Command\RemoveBasketTeamPlayerCommandHandler;
use Skeleton\BasketTeam\Domain\BasketTeam\Event\BasketTeamPlayerWasAlreadyRemoved;
use Skeleton\BasketTeam\Domain\BasketTeam\Event\BasketTeamPlayerWasRemoved;
use Skeleton\Kernel\Infrastructure\Tools\Uuid;
use Skeleton\Tests\Kernel\Application\CommandHandlerScenarioTestCase;
use Skeleton\Tests\Kernel\Domain\Specification\FailureSpecification;
use Skeleton\Tests\Kernel\Domain\Specification\SuccessSpecification;

final class RemoveBasketTeamPlayerCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    /**
     * @test
     */
    public function givenATeamAndANumberWhenPlayerExistsThenRemoveEvent(): void
    {
        $commandHandler = new RemoveBasketTeamPlayerCommandHandler(
            $numberExistInTheTeamSpecification = new SuccessSpecification()
        );

        $command = new RemoveBasketTeamPlayerCommand(
            $teamId = Uuid::v4(),
            $playerNumber = random_int(0,99)
        );

        $expectedEvent = new BasketTeamPlayerWasRemoved(
            $teamId,
            $playerNumber
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
    public function givenATeamAndANumberWhenPlayerDoesNoyExistThenAlreadyRemoveEvent(): void
    {
        $commandHandler = new RemoveBasketTeamPlayerCommandHandler(
            $numberExistInTheTeamSpecification = new FailureSpecification()
        );

        $command = new RemoveBasketTeamPlayerCommand(
            $teamId = Uuid::v4(),
            $playerNumber = random_int(0,99)
        );

        $expectedEvent = new BasketTeamPlayerWasAlreadyRemoved(
            $teamId,
            $playerNumber
        );

        $this
            ->scenario
            ->withCommandHandler($commandHandler)
            ->when($command)
            ->then($expectedEvent);
    }
}
