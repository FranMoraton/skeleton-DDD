<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Domain\BasketTeam\Specification;

use Skeleton\BasketTeam\Application\BasketTeam\Query\GetBasketTeamPlayerByNumberQuery;
use Skeleton\BasketTeam\Domain\BasketTeam\QueryModel\BasketTeamPlayerByNumberQuery;
use Skeleton\Kernel\Domain\Specification\Specification;

final class NumberExistInTheTeamSpecification implements Specification
{
    /**
     * @var BasketTeamPlayerByNumberQuery
     */
    private $byNumberQuery;

    public function __construct(BasketTeamPlayerByNumberQuery $byNumberQuery)
    {
        $this->byNumberQuery = $byNumberQuery;
    }

    public function isSatisfiedBy($object): bool
    {
        $criteria = new GetBasketTeamPlayerByNumberQuery($object->teamId(), $object->number());
        return 0 < count($this->byNumberQuery->find($criteria));
    }
}
