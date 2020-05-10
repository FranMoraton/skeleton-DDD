<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Application\BasketTeam\Command;

use Skeleton\Kernel\Application\Command\Command;

final class AddBasketTeamPlayerCommand implements Command
{
    /**
     * @var string
     */
    private $teamId;
    /**
     * @var int
     */
    private $number;
    /**
     * @var string
     */
    private $name;
    /**
     * @var float
     */
    private $averageRating;
    /**
     * @var string
     */
    private $role;

    public function __construct(string $teamId, int $number, string $name, float $averageRating, string $role)
    {
        $this->teamId = $teamId;
        $this->number = $number;
        $this->name = $name;
        $this->averageRating = $averageRating;
        $this->role = $role;
    }

    public function teamId(): string
    {
        return $this->teamId;
    }

    public function number(): int
    {
        return $this->number;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function averageRating(): float
    {
        return $this->averageRating;
    }

    public function role(): string
    {
        return $this->role;
    }
}
