<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Infrastructure\BasketTeam\Domain\QueryModel\InMemory;

use Skeleton\BasketTeam\Application\BasketTeam\Query\GetBasketTeamByCriteriaQuery;
use Skeleton\BasketTeam\Domain\BasketTeam\QueryModel\BasketTeamByCriteriaQuery;

final class InMemoryBasketTeamByCriteriaQuery implements BasketTeamByCriteriaQuery
{
    public function find(GetBasketTeamByCriteriaQuery $query): array
    {
        return [];
    }
}
