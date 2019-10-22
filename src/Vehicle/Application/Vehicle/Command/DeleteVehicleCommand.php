<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Application\Vehicle\Command;

use Skeleton\Kernel\Application\Command\Command;

final class DeleteVehicleCommand implements Command
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
