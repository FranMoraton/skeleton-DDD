<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Domain\Vehicle\Event;

use Skeleton\Kernel\Domain\Event\DomainEvent;

final class VehicleWasDeleted implements DomainEvent
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function getNameEvent(): string
    {
        return 'skeleton.vehicle.event.1.vehicle.deleted';
    }

    public function id(): string
    {
        return $this->id;
    }
}
