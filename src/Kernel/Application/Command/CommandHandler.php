<?php

namespace Skeleton\Kernel\Application\Command;

use Skeleton\Kernel\Domain\Event\EventStream;

interface CommandHandler
{
    public function handle(): EventStream;
}
