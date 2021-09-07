<?php

namespace Rinsvent\RedisManagerBundle\Service\Encoder;

use Rinsvent\RedisManagerBundle\Attribute\EncodeOptions;

class PlainEncoder extends AbstractEncoder
{
    public const FORMAT = 'plain';

    public function encode(object $object, EncodeOptions $encodeOptions): string
    {
        $reflectionProperty = new \ReflectionProperty($object, $encodeOptions->property);
        if (!$reflectionProperty->isInitialized($object)) {
            return '';
        }
        if (!$reflectionProperty->isPublic()) {
            $reflectionProperty->setAccessible(true);
        }
        $value = $reflectionProperty->getValue($object);
        if (!$reflectionProperty->isPublic()) {
            $reflectionProperty->setAccessible(false);
        }
        return $value;
    }

    public function decode(object $object, string $data, EncodeOptions $encodeOptions): object
    {
        $reflectionProperty = new \ReflectionProperty($object, $encodeOptions->property);
        if (!$reflectionProperty->isPublic()) {
            $reflectionProperty->setAccessible(true);
        }
        $reflectionProperty->setValue($object, $data);
        if (!$reflectionProperty->isPublic()) {
            $reflectionProperty->setAccessible(false);
        }
        return $object;
    }
}
