<?php

declare(strict_types=1);

namespace Skeleton\Kernel\Infrastructure\Application;

use Skeleton\Kernel\Application\Query\Query;
use Skeleton\Kernel\Application\Query\QueryBus;

final class TacticianQueryBus implements QueryBus
{
    private $queryBus;

    public function __construct(\League\Tactician\CommandBus $commandBus)
    {
        $this->queryBus = $commandBus;
    }

    public function execute(Query $query)
    {
        return $this->queryBus->handle($query);
    }
}
