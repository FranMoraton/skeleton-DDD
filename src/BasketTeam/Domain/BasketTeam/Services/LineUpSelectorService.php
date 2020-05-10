<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Domain\BasketTeam\Services;

use Skeleton\BasketTeam\Application\BasketTeam\Query\GetBasketTeamByCriteriaQuery;
use Skeleton\BasketTeam\Application\BasketTeam\Query\GetBetterTeamByLineUpQuery;
use Skeleton\BasketTeam\Domain\BasketTeam\QueryModel\BasketTeamByCriteriaQuery;
use Skeleton\BasketTeam\Domain\LineUp\Model\LineUp;

final class LineUpSelectorService
{
    private const LINE_UP_PLAYERS = 5;
    /**
     * @var BasketTeamByCriteriaQuery
     */
    private $basketTeamByCriteriaQuery;

    public function __construct(BasketTeamByCriteriaQuery $basketTeamByCriteriaQuery)
    {
        $this->basketTeamByCriteriaQuery = $basketTeamByCriteriaQuery;
    }

    public function execute(GetBetterTeamByLineUpQuery $query): array
    {
        $lineUp = $this->selectLineUp($query->lineUp());

        if (null === $lineUp) {
            return [];
        }

        $basketTeamQuery = new GetBasketTeamByCriteriaQuery();
        $basketTeamQuery = $basketTeamQuery->withTeamId($query->teamId())
            ->withOrder(BasketTeamByCriteriaQuery::DEFAULT_ORDER_DIRECTION)
            ->withOrderBy(BasketTeamByCriteriaQuery::DEFAULT_ORDER_BY);

        $basketTeam = $this->basketTeamByCriteriaQuery->find($basketTeamQuery);

        return $this->findBestPlayersForLineUp($lineUp, $basketTeam);
    }

    private function selectLineUp(string $lineUpName): ?LineUp
    {
        return LineUp::create($lineUpName);
    }

    private function findBestPlayersForLineUp(LineUp $lineUp, array $basketTeam): array
    {
        $basketTeamPlayers = current($basketTeam)['players'];

        $bestLineUp = [];
        $rolesMapped = [];

        foreach ($lineUp->roles() as $role) {
            if (false === array_key_exists($role, $rolesMapped)) {
                $rolesMapped [$role] = 1;
            }
            if (array_key_exists($role, $rolesMapped)) {
                ++$rolesMapped [$role];
            }
        }

        foreach ($basketTeamPlayers as $player) {
            if (array_key_exists($player['role'], $rolesMapped) && 0 < $rolesMapped[$player['role']]) {
                $bestLineUp [] = $player;
                --$rolesMapped[$player['role']];
            }
        }

        if (self::LINE_UP_PLAYERS !== count($bestLineUp)) {
            return [];
        }

        return $bestLineUp;
    }
}
