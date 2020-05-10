<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Application\BasketTeam\Query;

use Skeleton\BasketTeam\Domain\BasketTeam\Services\LineUpSelectorService;
use Skeleton\Kernel\Application\Query\QueryHandler;

final class GetBetterTeamByLineUpQueryHandler implements QueryHandler
{
    /**
     * @var LineUpSelectorService
     */
    private $lineUpSelectorService;

    public function __construct(LineUpSelectorService $lineUpSelectorService)
    {
        $this->lineUpSelectorService = $lineUpSelectorService;
    }

    public function handle(GetBetterTeamByLineUpQuery $query = null)
    {
        return $this->lineUpSelectorService->execute($query);
    }
}
