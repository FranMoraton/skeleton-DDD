<?php

declare(strict_types=1);

namespace Skeleton\Kernel\Infrastructure\Persistence\InMemory;

use Skeleton\Kernel\Domain\Model\StoredEvent;
use Skeleton\Kernel\Domain\Model\StoredEventRepository;
use Skeleton\Kernel\Infrastructure\Tools\Uuid;

final class InMemoryStoredEventRepository implements StoredEventRepository
{
    public function nextIdEntity(): string
    {
        return Uuid::v4();
    }

    public function add(StoredEvent $event): void
    {
        // TODO: Implement add() method.
    }

    public function persist(StoredEvent $event): void
    {
        // TODO: Implement flush() method.
    }
}
