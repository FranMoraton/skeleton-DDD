<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Infrastructure\BasketTeam\UI\Messaging\Subscribers;

use Skeleton\BasketTeam\Domain\BasketTeam\Event\BasketTeamPlayerWasRemoved;
use Skeleton\BasketTeam\Domain\BasketTeam\Model\Aggregate\PlayerState;
use Skeleton\BasketTeam\Domain\BasketTeam\Model\BasketTeamRepository;
use Skeleton\BasketTeam\Domain\BasketTeam\Model\BasketTeamState;
use Skeleton\Kernel\Domain\Event\DomainEvent;
use Skeleton\Kernel\Domain\Event\DomainEventSubscriber;

final class BasketTeamPlayerWasRemovedSubscriber implements DomainEventSubscriber
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
        BasketTeamPlayerWasRemoved $basketTeamPlayerWasRemoved
    ): BasketTeamState {
        $updatedBasketTeamPlayers = array_filter(
            $basketTeamState->players(),
            static function (PlayerState $item) use ($basketTeamPlayerWasRemoved) {
                return $item->number() !== $basketTeamPlayerWasRemoved->number();
            }
        );

        return $basketTeamState->withPlayers(...$updatedBasketTeamPlayers);
    }

    public function hydrate(array $msgData): DomainEvent
    {
        return new BasketTeamPlayerWasRemoved(
            $msgData['aggregateId'],
            (int) $msgData['number']
        );
    }
}
