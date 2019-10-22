<?php

namespace Skeleton\Kernel\Domain\Model;

interface StoredEventRepository
{
    public function nextIdEntity(): string;
    public function add(StoredEvent $event): void;
    public function persist(StoredEvent $event): void;
}
