<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Domain\LineUp\Model;

use Skeleton\BasketTeam\Domain\BasketTeam\Model\Aggregate\PlayerState;
use Skeleton\BasketTeam\Domain\Role\Model\Role;

class LineUp
{
    public const DEFENSE = 'defense';
    private const DEFENSE_LINEUP = [
        Role::BASE,
        Role::ESCOLTA,
        Role::ESCOLTA,
        Role::ALA_PIVOT,
        Role::PIVOT,
    ];

    public const ZONE_DEFENSE = 'zoneDefense';
    private const ZONE_DEFENSE_LINEUP = [
        Role::BASE,
        Role::BASE,
        Role::ALERO,
        Role::PIVOT,
        Role::ALA_PIVOT,
    ];

    public const ATTACK = 'attack';
    private const ATTACK_LINEUP = [
        Role::BASE,
        Role::ALERO,
        Role::ESCOLTA,
        Role::ALA_PIVOT,
        Role::PIVOT,
    ];

    public const LINEUPS = [
        self::ATTACK => self::ATTACK_LINEUP,
        self::ZONE_DEFENSE => self::ZONE_DEFENSE_LINEUP,
        self::DEFENSE => self::DEFENSE_LINEUP,
    ];

    /**
     * @var string
     */
    private $name;
    /**
     * @var string[]
     */
    private $roles;

    private function __construct(string $name, array $roles)
    {
        $this->name = $name;
        $this->roles = $roles;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function roles(): array
    {
        return $this->roles;
    }

    public static function create(string $name): ?LineUp
    {
        if (false === array_key_exists($name, self::LINEUPS)) {
            return null;
        }

        return new self($name, self::LINEUPS[$name]);
    }
}
