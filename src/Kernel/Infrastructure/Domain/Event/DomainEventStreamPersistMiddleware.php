<?php

declare(strict_types=1);

namespace Skeleton\Kernel\Infrastructure\Domain\Event;

use League\Tactician\Middleware;
use Skeleton\Kernel\Domain\Event\EventStream;
use Skeleton\Kernel\Domain\Service\EventAppender;

final class DomainEventStreamPersistMiddleware implements Middleware
{
    /**
     * @var EventAppender
     */
    private $eventAppender;

    public function __construct(EventAppender $eventAppender)
    {
        $this->eventAppender = $eventAppender;
    }

    public function execute($command, callable $next) : EventStream
    {
        $returnValue = $next($command);

        foreach ($returnValue->eventStream()->domainEvents() as $event) {
            $this->eventAppender->append($event);
        }

        return $returnValue;
    }
}
