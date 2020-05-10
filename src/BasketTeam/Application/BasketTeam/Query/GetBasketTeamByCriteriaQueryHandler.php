<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Application\BasketTeam\Query;

use Skeleton\BasketTeam\Domain\BasketTeam\QueryModel\BasketTeamByCriteriaQuery;
use Skeleton\Kernel\Application\Query\QueryHandler;

final class GetBasketTeamByCriteriaQueryHandler implements QueryHandler
{
    /**
     * @var BasketTeamByCriteriaQuery
     */
    private $basketTeamByCriteriaQuery;

    public function __construct(BasketTeamByCriteriaQuery $basketTeamByCriteriaQuery)
    {
        $this->basketTeamByCriteriaQuery = $basketTeamByCriteriaQuery;
    }

    public function handle(GetBasketTeamByCriteriaQuery $query = null)
    {
        return $this->basketTeamByCriteriaQuery->find($query);
    }
}
