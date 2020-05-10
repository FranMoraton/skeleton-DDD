<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Application\BasketTeam\Query;

use Skeleton\Kernel\Application\Query\Query;

final class GetBetterTeamByLineUpQuery implements Query
{
    /**
     * @var string
     */
    private $teamId;
    /**
     * @var string
     */
    private $lineUp;

    public function __construct(string $teamId, string $lineUp)
    {
        $this->teamId = $teamId;
        $this->lineUp = $lineUp;
    }

    public function teamId(): string
    {
        return $this->teamId;
    }

    public function lineUp(): string
    {
        return $this->lineUp;
    }
}
