<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Domain\Vehicle\Event;

use Skeleton\Kernel\Domain\Event\DomainEvent;
use Skeleton\Kernel\Domain\Event\FailureDomainEvent;

final class VehicleCreatorFailed implements FailureDomainEvent, DomainEvent
{
    public const NAME_WAS_IN_USE = 'Name was in use';
    /**
     * @var string
     */
    private $reason;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $driver;

    public function __construct(string $reason, string $name, string $driver)
    {
        $this->reason = $reason;
        $this->name = $name;
        $this->driver = $driver;
    }

    public static function getNameEvent(): string
    {
        return 'skeleton.vehicle.event.1.vehicle.creatorFailed';
    }

    public function reason(): string
    {
        $this->reason;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function driver(): string
    {
        return $this->driver;
    }
}
