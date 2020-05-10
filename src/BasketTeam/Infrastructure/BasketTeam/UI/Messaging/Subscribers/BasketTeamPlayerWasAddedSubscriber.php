<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Infrastructure\BasketTeam\UI\Messaging\Subscribers;

use Skeleton\BasketTeam\Domain\BasketTeam\Event\BasketTeamPlayerWasAdded;
use Skeleton\BasketTeam\Domain\BasketTeam\Model\Aggregate\PlayerState;
use Skeleton\BasketTeam\Domain\BasketTeam\Model\BasketTeamRepository;
use Skeleton\BasketTeam\Domain\BasketTeam\Model\BasketTeamState;
use Skeleton\Kernel\Domain\Event\DomainEvent;
use Skeleton\Kernel\Domain\Event\DomainEventSubscriber;

final class BasketTeamPlayerWasAddedSubscriber implements DomainEventSubscriber
{
    /**
     * @var BasketTeamRepository
     */
    private $basketTeamRepository;

    public function __construct(BasketTeamRepository $basketTeamRepository)
    {
        $this->basketTeamRepository = $basketTeamRepository;
    }

    public function handle(DomainEvent $aDomainEvent)
    {
        $basketTeamState = $this->basketTeamRepository->ofId($aDomainEvent->aggregateId());

        $this->basketTeamRepository->update(
            $this->makeProjection($basketTeamState, $aDomainEvent)
        );
    }

    private function makeProjection(
        BasketTeamState $basketTeamState,
        BasketTeamPlayerWasAdded $basketTeamPlayerWasAdded
    ): BasketTeamState {
        $updatedBasketTeamPlayers = array_merge(
            $basketTeamState->players(),
            [new PlayerState(
                $basketTeamPlayerWasAdded->aggregateId(),
                $basketTeamPlayerWasAdded->number(),
                $basketTeamPlayerWasAdded->name(),
                $basketTeamPlayerWasAdded->averageRating(),
                $basketTeamPlayerWasAdded->role()
            )]
        );

        return $basketTeamState->withPlayers(...$updatedBasketTeamPlayers);
    }

    public function hydrate(array $msgData): DomainEvent
    {
        return new BasketTeamPlayerWasAdded(
            $msgData['aggregateId'],
            (int) $msgData['number'],
            $msgData['name'],
            (float) $msgData['averageRating'],
            $msgData['role']
        );
    }
}
