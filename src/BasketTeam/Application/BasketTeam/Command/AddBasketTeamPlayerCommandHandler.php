<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Application\BasketTeam\Command;

use Skeleton\BasketTeam\Domain\BasketTeam\Model\BasketTeamPlayerAdder;
use Skeleton\BasketTeam\Domain\BasketTeam\Specification\NumberExistInTheTeamSpecification;
use Skeleton\Kernel\Application\Command\CommandHandler;
use Skeleton\Kernel\Domain\Event\EventStream;
use Skeleton\Kernel\Domain\Specification\Specification;

final class AddBasketTeamPlayerCommandHandler implements CommandHandler
{
    /**
     * @var NumberExistInTheTeamSpecification
     */
    private $numberExistInTheTeamSpecification;

    public function __construct(Specification $numberExistInTheTeamSpecification)
    {
        $this->numberExistInTheTeamSpecification = $numberExistInTheTeamSpecification;
    }

    public function handle(AddBasketTeamPlayerCommand $command = null): EventStream
    {
        return BasketTeamPlayerAdder::execute(
            $this->numberExistInTheTeamSpecification,
            $command
        );
    }
}
