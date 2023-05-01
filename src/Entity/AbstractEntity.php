<?php

namespace Itis6120\Project2\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Itis6120\Project2\EntityInterface;
use ReflectionClass;
use ReflectionObject;
use ReflectionProperty;

class AbstractEntity implements EntityInterface
{
    /**
     * Return the fields configured for the entity as human-readable.
     * @return string[]
     */
    public static function getFields(): array
    {
        $reflectionClass = new ReflectionClass(static::class);
        return array_map(static function(ReflectionProperty $property): string {
            return ucwords(preg_replace('/([A-Z0-9])/', ' $1', $property->getName()));
        }, $reflectionClass->getProperties(ReflectionProperty::IS_PRIVATE));
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $reflectionObject = new ReflectionObject($this);
        return array_reduce($reflectionObject->getProperties(), function(array $results, ReflectionProperty $property): array {
            $value = $property->getValue($this);

            if ($value instanceof DateTimeInterface) {
                $value = $value->format('m/d/Y H:i');
            } else if (is_object($value) && method_exists($value, '__toString')) {
                $value = (string)$value;
            } else if (is_array($value) || $value instanceof Collection) {
                return $results;
            }

            $results[$property->getName()] = $value;
            return $results;
        }, []);
    }
}
