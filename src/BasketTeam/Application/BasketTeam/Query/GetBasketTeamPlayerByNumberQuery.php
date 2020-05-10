<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Application\BasketTeam\Query;

use Skeleton\Kernel\Application\Query\Query;

final class GetBasketTeamPlayerByNumberQuery implements Query
{
    /**
     * @var string
     */
    private $teamId;
    /**
     * @var int
     */
    private $playerNumber;

    public function __construct(string $teamId, int $playerNumber)
    {
        $this->teamId = $teamId;
        $this->playerNumber = $playerNumber;
    }

    public function teamId(): string
    {
        return $this->teamId;
    }

    public function playerNumber(): int
    {
        return $this->playerNumber;
    }
}
