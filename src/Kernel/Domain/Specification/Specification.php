<?php

namespace Skeleton\Kernel\Domain\Specification;

interface Specification
{
    public function isSatisfiedBy($object): bool;
}
