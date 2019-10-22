<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Domain\Vehicle\Event;

use Skeleton\Kernel\Domain\Event\DomainEvent;

final class VehicleWasCreated implements DomainEvent
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $driver;

    public function __construct(string $id, string $name, string $driver)
    {
        $this->id = $id;
        $this->name = $name;
        $this->driver = $driver;
    }

    public static function getNameEvent(): string
    {
        return 'skeleton.vehicle.event.1.vehicle.created';
    }

    public function id(): string
    {
        return $this->id;
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
