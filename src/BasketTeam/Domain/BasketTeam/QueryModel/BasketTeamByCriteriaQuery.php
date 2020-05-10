<?php

namespace Skeleton\BasketTeam\Domain\BasketTeam\QueryModel;

use Skeleton\BasketTeam\Application\BasketTeam\Query\GetBasketTeamByCriteriaQuery;

interface BasketTeamByCriteriaQuery
{
    public const DEFAULT_ORDER_BY = 'averageRating';
    public const DEFAULT_ORDER_DIRECTION = 'desc';

    public function find(GetBasketTeamByCriteriaQuery $query): array;
}
