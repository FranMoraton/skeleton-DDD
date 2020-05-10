<?php
declare(strict_types=1);

namespace Skeleton\Tests\BasketTeam\Application\BasketTeam\Command;

use Skeleton\BasketTeam\Application\BasketTeam\Command\AddBasketTeamPlayerCommand;
use Skeleton\BasketTeam\Application\BasketTeam\Command\AddBasketTeamPlayerCommandHandler;
use Skeleton\BasketTeam\Domain\BasketTeam\Event\BasketTeamPlayerAdderFailed;
use Skeleton\BasketTeam\Domain\BasketTeam\Event\BasketTeamPlayerWasAdded;
use Skeleton\BasketTeam\Domain\Role\Model\Role;
use Skeleton\Kernel\Infrastructure\Tools\Uuid;
use Skeleton\Tests\Kernel\Application\CommandHandlerScenarioTestCase;
use Skeleton\Tests\Kernel\Domain\Specification\FailureSpecification;
use Skeleton\Tests\Kernel\Domain\Specification\SuccessSpecification;

final class AddBasketTeamPlayerCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    /**
     * @test
     */
    public function givenANumberWhichExistsInTeamWhenAddingThePlayerThenAdderFailedEvent(): void
    {
        $commandHandler = new AddBasketTeamPlayerCommandHandler(
            $numberExistInTheTeamSpecification = new SuccessSpecification()
        );

        $command = new AddBasketTeamPlayerCommand(
            $teamId = Uuid::v4(),
            $number = 33,
            $name = 'fran',
            $averageRating = 50,
            $role = Role::BASE
        );

        $expectedEvent = new BasketTeamPlayerAdderFailed(
            BasketTeamPlayerAdderFailed::NUMBER_EXIST_IN_THE_TEAM,
            $teamId,
            $number,
            $name,
            $averageRating,
            $role
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
    public function givenAnInvalidRoleWhenAddingThePlayerThenAdderFailedEvent(): void
    {
        $commandHandler = new AddBasketTeamPlayerCommandHandler(
            $numberExistInTheTeamSpecification = new FailureSpecification()
        );

        $command = new AddBasketTeamPlayerCommand(
            $teamId = Uuid::v4(),
            $number = 33,
            $name = 'fran',
            $averageRating = 50,
            $role = 'randomRole'
        );

        $expectedEvent = new BasketTeamPlayerAdderFailed(
            BasketTeamPlayerAdderFailed::INVALID_ROLE,
            $teamId,
            $number,
            $name,
            $averageRating,
            $role
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
    public function givenANotInRangeAverageRatingWhenAddingThePlayerThenAdderFailedEvent(): void
    {
        $commandHandler = new AddBasketTeamPlayerCommandHandler(
            $numberExistInTheTeamSpecification = new FailureSpecification()
        );

        $command = new AddBasketTeamPlayerCommand(
            $teamId = Uuid::v4(),
            $number = 33,
            $name = 'fran',
            $averageRating = 100,
            $role = Role::BASE
        );

        $expectedEvent = new BasketTeamPlayerAdderFailed(
            BasketTeamPlayerAdderFailed::AVERAGE_RATING_NOT_IN_RANGE,
            $teamId,
            $number,
            $name,
            $averageRating,
            $role
        );

        $this
            ->scenario
            ->withCommandHandler($commandHandler)
            ->when($command)
            ->then($expectedEvent);
    }

    public function givenAValidCommandWhenAddingThePlayerThenWasAddedEvent(): void
    {
        $commandHandler = new AddBasketTeamPlayerCommandHandler(
            $numberExistInTheTeamSpecification = new FailureSpecification()
        );

        $command = new AddBasketTeamPlayerCommand(
            $teamId = Uuid::v4(),
            $number = 33,
            $name = 'fran',
            $averageRating = 88,
            $role = Role::BASE
        );

        $expectedEvent = new BasketTeamPlayerWasAdded(
            $teamId,
            $number,
            $name,
            $averageRating,
            $role
        );

        $this
            ->scenario
            ->withCommandHandler($commandHandler)
            ->when($command)
            ->then($expectedEvent);
    }
}
