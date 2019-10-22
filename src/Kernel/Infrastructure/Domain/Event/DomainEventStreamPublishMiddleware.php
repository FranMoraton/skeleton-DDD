<?php

declare(strict_types=1);

namespace Skeleton\Kernel\Infrastructure\Domain\Event;

use League\Tactician\Middleware;
use Skeleton\Kernel\Application\EventNotification;
use Skeleton\Kernel\Domain\Event\EventStream;

final class DomainEventStreamPublishMiddleware implements Middleware
{
    /**
     * @var EventNotification
     */
    private $eventNotification;

    public function __construct(EventNotification $eventNotification)
    {
        $this->eventNotification = $eventNotification;
    }

    public function execute($command, callable $next) : EventStream
    {
        $returnValue = $next($command);

        foreach ($returnValue->eventStream()->domainEvents() as $event) {
            $this->eventNotification->publish($event);
        }

        return $returnValue;
    }
}
