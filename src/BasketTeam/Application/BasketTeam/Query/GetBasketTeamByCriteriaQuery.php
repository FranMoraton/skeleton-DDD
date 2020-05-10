<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Application\BasketTeam\Query;

use Skeleton\Kernel\Application\Query\Query;

final class GetBasketTeamByCriteriaQuery implements Query
{
    /**
     * @var string
     */
    private $teamId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string|null
     */
    private $order;
    /**
     * @var string|null
     */
    private $orderBy;

    public function teamId(): string
    {
        return $this->teamId;
    }

    public function withTeamId(string $teamId): self
    {
        $clone = clone $this;
        $clone->teamId = $teamId;
        return $clone;
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

    public function order(): ?string
    {
        return $this->order;
    }

    public function withOrder(?string $order): self
    {
        $clone = clone $this;
        $clone->order = $order;
        return $clone;
    }

    public function orderBy(): ?string
    {
        return $this->orderBy;
    }

    public function withOrderBy(?string $orderBy): self
    {
        $clone = clone $this;
        $clone->orderBy = $orderBy;
        return $clone;
    }
}
