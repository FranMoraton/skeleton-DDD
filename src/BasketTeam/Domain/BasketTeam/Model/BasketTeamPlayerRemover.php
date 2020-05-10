<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Domain\BasketTeam\Model;

use Skeleton\BasketTeam\Application\BasketTeam\Command\RemoveBasketTeamPlayerCommand;
use Skeleton\BasketTeam\Domain\BasketTeam\Event\BasketTeamPlayerWasAlreadyRemoved;
use Skeleton\BasketTeam\Domain\BasketTeam\Event\BasketTeamPlayerWasRemoved;
use Skeleton\BasketTeam\Domain\BasketTeam\Specification\NumberExistInTheTeamSpecification;
use Skeleton\BasketTeam\Domain\BasketTeam\Specification\NumberExistInTheTeamSpecificationObject;
use Skeleton\Kernel\Domain\Event\EventStream;
use Skeleton\Kernel\Domain\Specification\Specification;

final class BasketTeamPlayerRemover
{
    public static function execute(
        Specification $numberExistInTheTeamSpecification,
        RemoveBasketTeamPlayerCommand $command
    ): EventStream {
        $specificationObject = new NumberExistInTheTeamSpecificationObject(
            $command->teamId(),
            $command->number()
        );
        if (false === $numberExistInTheTeamSpecification->isSatisfiedBy($specificationObject)) {
            return EventStream::fromDomainEvents(
                new BasketTeamPlayerWasAlreadyRemoved(
                    $command->teamId(),
                    $command->number()
                )
            );
        }

        return EventStream::fromDomainEvents(
            new BasketTeamPlayerWasRemoved(
                $command->teamId(),
                $command->number()
            )
        );
    }
}
