<?php

declare(strict_types=1);

namespace Skeleton\Kernel\Infrastructure\Application;

use Skeleton\Kernel\Application\Command\Command;
use Skeleton\Kernel\Application\Command\CommandBus;
use Skeleton\Kernel\Domain\Event\EventStream;

final class TacticianCommandBus implements CommandBus
{
    private $commandBus;

    public function __construct(\League\Tactician\CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function execute(Command $command) : EventStream
    {
        return $this->commandBus->handle($command);
    }
}
