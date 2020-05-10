<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Domain\BasketTeam\Model;

use Skeleton\BasketTeam\Application\BasketTeam\Command\AddBasketTeamPlayerCommand;
use Skeleton\BasketTeam\Domain\BasketTeam\Event\BasketTeamPlayerAdderFailed;
use Skeleton\BasketTeam\Domain\BasketTeam\Event\BasketTeamPlayerWasAdded;
use Skeleton\BasketTeam\Domain\BasketTeam\Specification\NumberExistInTheTeamSpecification;
use Skeleton\BasketTeam\Domain\BasketTeam\Specification\NumberExistInTheTeamSpecificationObject;
use Skeleton\BasketTeam\Domain\Role\Model\Role;
use Skeleton\Kernel\Domain\Event\EventStream;
use Skeleton\Kernel\Domain\Specification\Specification;

final class BasketTeamPlayerAdder
{
    public static function execute(
        Specification $numberExistInTheTeamSpecification,
        AddBasketTeamPlayerCommand $command
    ): EventStream {
        $events = [];

        $specificationObject = new NumberExistInTheTeamSpecificationObject(
            $command->teamId(),
            $command->number()
        );

        if ($numberExistInTheTeamSpecification->isSatisfiedBy($specificationObject)) {
            $events [] = self::failureEvent(
                BasketTeamPlayerAdderFailed::NUMBER_EXIST_IN_THE_TEAM,
                $command
            );
        }

        if (null === Role::create($command->role())) {
            $events [] = self::failureEvent(
                BasketTeamPlayerAdderFailed::INVALID_ROLE,
                $command
            );
        }

        if (false === self::averageRatingInRange($command->averageRating())) {
            $events [] = self::failureEvent(
                BasketTeamPlayerAdderFailed::AVERAGE_RATING_NOT_IN_RANGE,
                $command
            );
        }

        if (0 < count($events)) {
            return EventStream::fromDomainEvents(...$events);
        }

        return EventStream::fromDomainEvents(
            new BasketTeamPlayerWasAdded(
                $command->teamId(),
                $command->number(),
                $command->name(),
                $command->averageRating(),
                $command->role()
            )
        );
    }

    private static function averageRatingInRange(float $averageRating): bool
    {
        return (float) 0 <= $averageRating && (float) 100 > $averageRating;
    }

    private static function failureEvent(
        string $reason,
        AddBasketTeamPlayerCommand $command
    ): BasketTeamPlayerAdderFailed {
        return new BasketTeamPlayerAdderFailed(
            $reason,
            $command->teamId(),
            $command->number(),
            $command->name(),
            $command->averageRating(),
            $command->role()
        );
    }
}
