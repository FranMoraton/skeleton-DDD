<?php

namespace Skeleton\Kernel\Application\Query;

interface QueryBus
{
    public function execute(Query $query);
}
