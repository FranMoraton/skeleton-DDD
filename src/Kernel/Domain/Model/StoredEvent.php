<?php

declare(strict_types=1);

namespace Skeleton\Kernel\Domain\Model;

class StoredEvent
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $typeName;
    /**
     * @var \DateTime
     */
    private $occurredOn;
    /**
     * @var string
     */
    private $eventBody;

    public function __construct(
        string $id,
        string $typeName,
        \DateTime $occurredOn,
        string $eventBody
    )
    {
        $this->id = $id;
        $this->typeName = $typeName;
        $this->occurredOn = $occurredOn;
        $this->eventBody = $eventBody;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function typeName(): string
    {
        return $this->typeName;
    }

    public function occurredOn(): \DateTime
    {
        return $this->occurredOn;
    }

    public function eventBody(): string
    {
        return $this->eventBody;
    }
}
