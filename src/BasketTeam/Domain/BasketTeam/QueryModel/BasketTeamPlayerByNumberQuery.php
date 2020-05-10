<?php

namespace Skeleton\BasketTeam\Domain\BasketTeam\QueryModel;

use Skeleton\BasketTeam\Application\BasketTeam\Query\GetBasketTeamPlayerByNumberQuery;

interface BasketTeamPlayerByNumberQuery
{
    public function find(GetBasketTeamPlayerByNumberQuery $query): array;
}
