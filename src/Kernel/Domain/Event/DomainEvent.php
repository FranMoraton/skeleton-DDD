<?php

namespace Skeleton\Kernel\Domain\Event;

interface DomainEvent
{
    public static function getNameEvent(): string;
}
