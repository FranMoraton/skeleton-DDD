<?php

namespace Skeleton\Kernel\Domain\Event;

interface Subscriber
{
    const OK = 1;
    const KO = -1;

    public function handle(array $data): int;
}
