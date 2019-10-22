<?php

namespace Skeleton\Kernel\Domain\Event;

interface FailureDomainEvent
{
    public function reason(): string;
}
