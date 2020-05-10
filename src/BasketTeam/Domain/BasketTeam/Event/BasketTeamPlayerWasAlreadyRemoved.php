<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Domain\BasketTeam\Event;

use Skeleton\Kernel\Domain\Event\DomainEvent;
use Skeleton\Kernel\Domain\Event\FailureDomainEvent;

final class BasketTeamPlayerWasAlreadyRemoved implements DomainEvent
{
    private const NAME = 'skeleton.basketTeam.event.1.player.alreadyRemoved';

    /**
     * @var string
     */
    private $aggregateId;
    /**
     * @var int
     */
    private $number;

    public function __construct(string $aggregateId, int $number)
    {
        $this->aggregateId = $aggregateId;
        $this->number = $number;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function number(): int
    {
        return $this->number;
    }

    public static function getNameEvent(): string
    {
        return self::NAME;
    }
}
