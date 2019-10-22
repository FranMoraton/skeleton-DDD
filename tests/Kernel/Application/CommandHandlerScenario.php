<?php

declare(strict_types=1);

namespace Skeleton\Tests\Kernel\Application;

use PHPUnit\Framework\Assert;
use Skeleton\Kernel\Application\Command\Command;
use Skeleton\Kernel\Application\Command\CommandHandler;
use Skeleton\Kernel\Domain\Event\DomainEvent;
use Skeleton\Kernel\Domain\Event\EventStream;

final class CommandHandlerScenario
{
    /**
     * @var EventStream
     */
    private $eventStream;

    /**
     * @var CommandHandler
     */
    private $commandHandler;

    public function withCommandHandler(CommandHandler $commandHandler): self
    {
        $this->commandHandler = $commandHandler;

        return $this;
    }

    public function when(Command $command): self
    {
        $this->eventStream = $this->commandHandler->handle($command);

        return $this;
    }

    public function then(DomainEvent ...$domainEvents): self
    {
        Assert::assertEquals(EventStream::fromDomainEvents(...$domainEvents), $this->eventStream);

        return $this;
    }
}
