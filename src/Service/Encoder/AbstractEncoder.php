<?php

namespace Rinsvent\RedisManagerBundle\Service\Encoder;

abstract class AbstractEncoder implements EncoderInterface
{
    public const FORMAT = '';

    public static function getLocatorKey()
    {
        return 'redis.encoder.' . static::FORMAT;
    }
}
