<?php

declare(strict_types=1);

namespace Skeleton\Kernel\Domain\Model\ValueObject;

final class GeoLocation
{
    /**
     * @var string
     */
    private $longitude;

    /**
     * @var string
     */
    private $latitude;

    private function __construct(string $longitude, string $latitude)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    public static function fromLongitudeAndLatitude(string $longitude, string $latitude): self
    {
        return new self($longitude, $latitude);
    }

    public function longitude(): string
    {
        return $this->longitude;
    }

    public function latitude(): string
    {
        return $this->latitude;
    }

    public function equals(GeoLocation $geoLocation): bool
    {
        return $this->latitude === $geoLocation->latitude() && $this->longitude === $geoLocation->longitude();
    }
}
