<?php

namespace Skeleton\Kernel\Application\Command;

use Skeleton\Kernel\Domain\Event\EventStream;

interface CommandBus
{
    public function execute(Command $command): EventStream;
}
