<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Domain\BasketTeam\Model;

interface BasketTeamRepository
{
    public function ofId(string $basketTeamId): ?BasketTeamState;
    public function add(BasketTeamState $basketTeamState): void;
    public function update(BasketTeamState $basketTeamState): void;
    public function remove(BasketTeamState $basketTeamState): void;
    public function nextId(): string;
}
