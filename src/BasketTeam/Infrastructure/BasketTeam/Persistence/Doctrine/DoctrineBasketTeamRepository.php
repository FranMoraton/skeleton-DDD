<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Infrastructure\BasketTeam\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Skeleton\BasketTeam\Domain\BasketTeam\Model\Aggregate\PlayerState;
use Skeleton\BasketTeam\Domain\BasketTeam\Model\BasketTeamRepository;
use Skeleton\BasketTeam\Domain\BasketTeam\Model\BasketTeamState;
use Skeleton\Kernel\Infrastructure\Tools\Uuid;

final class DoctrineBasketTeamRepository implements BasketTeamRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function ofId(string $basketTeamId): ?BasketTeamState
    {
        $basketTeamState = $this->entityManager->createQueryBuilder()
            ->select('basket_team_state')
            ->from(BasketTeamState::class, 'basket_team_state')
            ->where('basket_team_state.id = :basketTeamId')
            ->setParameter('basketTeamId', $basketTeamId)
            ->getQuery()
            ->getOneOrNullResult();

        if (null !== $basketTeamState) {
            $players = $this->findAggregatePlayers($basketTeamId);
            $basketTeamState = $basketTeamState->withPlayers(...$players);
        }

        return $basketTeamState;
    }

    public function add(BasketTeamState $basketTeamState): void
    {
        $this->entityManager->persist($basketTeamState);
        foreach ($basketTeamState->players() as $player) {
            $this->entityManager->persist($player);
        }
    }

    public function update(BasketTeamState $basketTeamState): void
    {
        $playersInDb = $this->findAggregatePlayers($basketTeamState->id());
        $playersInState = $basketTeamState->players();

        foreach ($playersInDb as $playerInDb) {
            $this->entityManager->remove($playerInDb);
        }

        foreach ($playersInState as $playerInState) {
            $this->entityManager->persist($playerInState);
        }

        $this->entityManager->merge($basketTeamState);
    }

    public function remove(BasketTeamState $basketTeamState): void
    {
        $this->entityManager->createQueryBuilder()
            ->delete(PlayerState::class, 'player_state')
            ->where('player_state.teamId = :basketTeamId')
            ->setParameter('basketTeamId', $basketTeamState->id())
            ->getQuery()
            ->execute();

        $this->entityManager->createQueryBuilder()
            ->delete(BasketTeamState::class, 'basket_team_state')
            ->where('basket_team_state.id = :basketTeamId')
            ->setParameter('basketTeamId', $basketTeamState->id())
            ->getQuery()
            ->execute();
    }

    public function nextId(): string
    {
        return Uuid::v4();
    }

    private function findAggregatePlayers(string $basketTeamId): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('player_state')
            ->from(PlayerState::class, 'player_state')
            ->where('player_state.teamId = :basketTeamId')
            ->setParameter('basketTeamId', $basketTeamId)
            ->getQuery()
            ->getArrayResult();
    }
}
