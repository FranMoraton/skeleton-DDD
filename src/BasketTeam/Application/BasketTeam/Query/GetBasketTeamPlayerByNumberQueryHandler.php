<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Application\BasketTeam\Query;

use Skeleton\BasketTeam\Domain\BasketTeam\QueryModel\BasketTeamPlayerByNumberQuery;
use Skeleton\Kernel\Application\Query\QueryHandler;

final class GetBasketTeamPlayerByNumberQueryHandler implements QueryHandler
{
    /**
     * @var BasketTeamPlayerByNumberQuery
     */
    private $byNumberQuery;

    public function __construct(BasketTeamPlayerByNumberQuery $byNumberQuery)
    {
        $this->byNumberQuery = $byNumberQuery;
    }

    public function handle(GetBasketTeamPlayerByNumberQuery $query = null)
    {
        return $this->byNumberQuery->find($query);
    }
}
