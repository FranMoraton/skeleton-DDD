<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Domain\BasketTeam\Event;

use Skeleton\Kernel\Domain\Event\DomainEvent;
use Skeleton\Kernel\Domain\Event\FailureDomainEvent;

final class BasketTeamPlayerAdderFailed implements DomainEvent, FailureDomainEvent
{
    private const NAME = 'skeleton.basketTeam.event.1.player.adderFailed';

    public const INVALID_ROLE = 'invalid role';
    public const AVERAGE_RATING_NOT_IN_RANGE = 'average rating not between 0 and 99';
    public const NUMBER_EXIST_IN_THE_TEAM = 'number exist in the team';

    /**
     * @var string
     */
    private $reason;
    /**
     * @var string
     */
    private $aggregateId;
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

    public function __construct(
        string $reason,
        string $aggregateId,
        int $number,
        string $name,
        float $averageRating,
        string $role
    ) {
        $this->reason = $reason;
        $this->aggregateId = $aggregateId;
        $this->number = $number;
        $this->name = $name;
        $this->averageRating = $averageRating;
        $this->role = $role;
    }

    public function reason(): string
    {
        return $this->reason;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
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

    public static function getNameEvent(): string
    {
        return self::NAME;
    }
}
