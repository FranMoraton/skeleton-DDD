<?php

namespace Skeleton\Kernel\Domain\Event;

interface DomainEventSubscriber
{
    public function handle(DomainEvent $aDomainEvent);
    public function hydrate(array $msgData): DomainEvent;
}
