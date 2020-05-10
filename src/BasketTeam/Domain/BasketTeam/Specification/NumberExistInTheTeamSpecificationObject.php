<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Domain\BasketTeam\Specification;

final class NumberExistInTheTeamSpecificationObject
{
    /**
     * @var string
     */
    private $teamId;
    /**
     * @var int
     */
    private $number;

    public function __construct(string $teamId, int $number)
    {
        $this->teamId = $teamId;
        $this->number = $number;
    }

    public function teamId(): string
    {
        return $this->teamId;
    }

    public function number(): int
    {
        return $this->number;
    }
}
