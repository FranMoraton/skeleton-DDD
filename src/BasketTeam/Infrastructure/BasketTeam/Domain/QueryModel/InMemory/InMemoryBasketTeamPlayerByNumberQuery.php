<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Infrastructure\BasketTeam\Domain\QueryModel\InMemory;

use Skeleton\BasketTeam\Application\BasketTeam\Query\GetBasketTeamPlayerByNumberQuery;
use Skeleton\BasketTeam\Domain\BasketTeam\QueryModel\BasketTeamPlayerByNumberQuery;

final class InMemoryBasketTeamPlayerByNumberQuery implements BasketTeamPlayerByNumberQuery
{
    public function find(GetBasketTeamPlayerByNumberQuery $query): array
    {
        return [];
    }
}
