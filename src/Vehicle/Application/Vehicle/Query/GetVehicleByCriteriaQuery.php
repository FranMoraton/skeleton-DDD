<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Application\Vehicle\Query;

use Skeleton\Kernel\Application\Query\Query;

final class GetVehicleByCriteriaQuery implements Query
{
    /**
     * @var string|null
     */
    private $name;

    public function name(): ?string
    {
        return $this->name;
    }

    public function withName(?string $name): self
    {
        $clone = clone $this;
        $clone->name = $name;
        return $clone;
    }
}
