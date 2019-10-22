<?php

declare(strict_types=1);

namespace Skeleton\Vehicle\Domain\Vehicle\Specification;

final class VehicleNameDoesNotExistSpecificationObject
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}
