<?php
declare(strict_types=1);

namespace Skeleton\BasketTeam\Domain\Role\Model;

class Role
{
    public const ALERO = 'alero';
    public const ALA_PIVOT = 'alaPivot';
    public const PIVOT = 'pivot';
    public const ESCOLTA = 'escolta';
    public const BASE = 'base';

    public const ALLOWED_ROLES = [
        self::ALERO => self::ALERO,
        self::ALA_PIVOT => self::ALA_PIVOT,
        self::PIVOT => self::PIVOT,
        self::ESCOLTA => self::ESCOLTA,
        self::BASE => self::BASE,
    ];
    /**
     * @var string
     */
    private $role;

    private function __construct(string $role)
    {
        $this->role = $role;
    }

    public function role(): string
    {
        return $this->role;
    }

    public static function create(string $role): ?self
    {
        if (false === array_key_exists($role, self::ALLOWED_ROLES)) {
            return null;
        }

        return new self($role);
    }

    public function isEqual(Role $role): bool
    {
        return $this->role === $role->role();
    }

    public function __toString(): string
    {
        return $this->role;
    }
}
