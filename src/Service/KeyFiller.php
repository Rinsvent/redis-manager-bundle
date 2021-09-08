<?php

namespace Rinsvent\RedisManagerBundle\Service;

use ReflectionProperty;

class KeyFiller
{
    public function fill(string $key, object $object): string
    {
        if (preg_match_all('#\{\$(.*?)\}#', $key, $matches)) {
            $marks = $matches[0] ?? [];
            foreach ($marks as $index => $mark) {
                $markCode = $matches[1][$index] ?? null;

                $markValue = null;
                $reflectionProperty = new ReflectionProperty($object, $markCode);
                if ($reflectionProperty->isInitialized($object)) {
                    if (!$reflectionProperty->isPublic()) {
                        $reflectionProperty->setAccessible(true);
                    }
                    $markValue = $reflectionProperty->getValue($object);
                    if (!$reflectionProperty->isPublic()) {
                        $reflectionProperty->setAccessible(false);
                    }
                }

                $key = strtr($key, [
                    $mark => $markValue
                ]);
            }
        }
        return $key;
    }
}
