<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Infrastructure\BasketTeam\Persistence\InMemory;

use Skeleton\BasketTeam\Domain\BasketTeam\Model\BasketTeamRepository;
use Skeleton\BasketTeam\Domain\BasketTeam\Model\BasketTeamState;
use Skeleton\Kernel\Infrastructure\Tools\Uuid;

final class InMemoryBasketTeamRepository implements BasketTeamRepository
{
    /**
     * @var null|BasketTeamState
     */
    private $mock = null;
    /**
     * @var bool
     */
    private $addWasCalled = false;
    /**
     * @var bool
     */
    private $removeWasCalled = false;
    /**
     * @var bool
     */
    private $updateWasCalled = false;
    /**
     * @var string
     */
    private $nextId;

    public function mockNextId(string $mockNextId): void
    {
        $this->nextId = $mockNextId;
    }

    public function mockWith(BasketTeamState $basketTeamState): void
    {
        $this->mock = $basketTeamState;
    }

    public function ofId(string $basketTeamId): ?BasketTeamState
    {
        return $this->mock;
    }

    public function add(BasketTeamState $basketTeamState): void
    {
        $this->addWasCalled = true;
    }

    public function update(BasketTeamState $basketTeamState): void
    {
        $this->updateWasCalled = true;
    }

    public function remove(BasketTeamState $basketTeamState): void
    {
        $this->removeWasCalled = true;
    }

    public function addWasCalled(): bool
    {
        return $this->addWasCalled;
    }

    public function removeWasCalled(): bool
    {
        return $this->removeWasCalled;
    }

    public function updateWasCalled(): bool
    {
        return $this->updateWasCalled;
    }

    public function nextId(): string
    {
        return $this->nextId ?? Uuid::v4();
    }
}
