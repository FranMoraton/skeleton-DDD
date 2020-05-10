<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Domain\BasketTeam\Event;

use Skeleton\Kernel\Domain\Event\DomainEvent;

final class BasketTeamPlayerWasAdded implements DomainEvent
{
    private const NAME = 'skeleton.basketTeam.event.1.player.added';

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

    public function __construct(string $aggregateId, int $number, string $name, float $averageRating, string $role)
    {
        $this->aggregateId = $aggregateId;
        $this->number = $number;
        $this->name = $name;
        $this->averageRating = $averageRating;
        $this->role = $role;
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
