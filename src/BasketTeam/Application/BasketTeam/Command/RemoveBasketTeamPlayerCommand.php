<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Application\BasketTeam\Command;

use Skeleton\Kernel\Application\Command\Command;

final class RemoveBasketTeamPlayerCommand implements Command
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
