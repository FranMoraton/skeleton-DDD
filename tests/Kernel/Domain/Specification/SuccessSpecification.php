<?php

declare(strict_types=1);

namespace Skeleton\Tests\Kernel\Domain\Specification;

use Skeleton\Kernel\Domain\Specification\Specification;

final class SuccessSpecification implements Specification
{
    public function isSatisfiedBy($object): bool
    {
        return true;
    }
}
