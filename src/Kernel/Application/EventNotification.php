<?php

namespace Skeleton\Kernel\Application;

use Skeleton\Kernel\Domain\Event\DomainEvent;

interface EventNotification
{
    public function publish(DomainEvent $aDomainEvent, array $headers = []);
}
