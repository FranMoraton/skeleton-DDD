<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Application\Vehicle\Command;

use Skeleton\Kernel\Application\Command\Command;

final class CreateVehicleCommand implements Command
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $driver;

    public function __construct(string $name, string $driver)
    {
        $this->name = $name;
        $this->driver = $driver;
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
