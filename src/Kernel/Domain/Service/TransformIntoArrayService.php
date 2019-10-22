<?php

declare(strict_types=1);

namespace Skeleton\Kernel\Domain\Service;

final class TransformIntoArrayService
{
    public static function objectToArray($object): array
    {
        $array = $object;

        if (is_object($object)) {
            $reflectionClass = new \ReflectionClass(get_class($object));
            $array = [];
            foreach ($reflectionClass->getProperties() as $property) {
                $property->setAccessible(true);
                $array[$property->getName()] = $property->getValue($object);
                if (is_object($property->getValue($object)))
                    $array[$property->getName()] = self::objectToArray($property->getValue($object));
                if (is_array($property->getValue($object)))
                    $array[$property->getName()] = self::arrayOfObjectsToArray($property->getValue($object));
                $property->setAccessible(false);
            }
        }

        return $array;
    }

    public static function arrayOfObjectsToArray(?array $objects): array
    {
        $arrayReturned = [];

        foreach ($objects as $object) {
            $arrayReturned[] = self::objectToArray($object);
        }

        return $arrayReturned;
    }
}
