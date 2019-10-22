<?php

declare(strict_types=1);

namespace Skeleton\Kernel\Domain\Event;

final class EventStream implements \Countable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var DomainEvent
     */
    private $domainEvents;

    public static function fromDomainEvents(DomainEvent ...$domainEvents): self
    {
        return new self(...$domainEvents);
    }

    private function __construct(DomainEvent ...$domainEvents)
    {
        $this->domainEvents = $domainEvents;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function count(): int
    {
        return count($this->domainEvents);
    }

    public function first(): DomainEvent
    {
        return $this->domainEvents[0];
    }

    /**
     * @return DomainEvent[]
     */
    public function domainEvents(): array
    {
        return $this->domainEvents;
    }
}
