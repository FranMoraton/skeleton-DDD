<?php

declare(strict_types=1);

namespace Skeleton\Tests\Kernel\Domain\Specification;

use Skeleton\Kernel\Domain\Specification\Specification;

final class FailureSpecification implements Specification
{
    public function isSatisfiedBy($object): bool
    {
        return false;
    }
}
