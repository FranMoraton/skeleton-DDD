<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Domain\BasketTeam\Model;

use Skeleton\BasketTeam\Domain\BasketTeam\Model\Aggregate\PlayerState;

class BasketTeamState
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var PlayerState[]
     */
    private $players;

    public function __construct(
        string $id,
        string $name,
        PlayerState ...$players
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->players = $players;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function withName(string $name): self
    {
        $clone = clone $this;
        $clone->name = $name;
        return $clone;
    }

    public function players(): array
    {
        return $this->players;
    }

    public function withPlayers(PlayerState ...$players): self
    {
        $clone = clone $this;
        $clone->players = $players;
        return $clone;
    }
}
