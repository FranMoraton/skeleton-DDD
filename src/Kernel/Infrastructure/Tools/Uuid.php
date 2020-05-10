<?php

declare(strict_types=1);

namespace Skeleton\Kernel\Infrastructure\Tools;

final class Uuid
{
    const NIL = '00000000-0000-0000-0000-000000000000';
    private const VALID_PATTERN = '^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$';

    public static function v4(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public static function isValid($uuid): bool
    {
        $uuid = str_replace(['urn:', 'uuid:', 'URN:', 'UUID:', '{', '}'], '', $uuid);

        if ($uuid == self::NIL) {
            return true;
        }

        if (!preg_match('/' . self::VALID_PATTERN . '/D', $uuid)) {
            return false;
        }

        return true;
    }
}
