<?php

namespace Rinsvent\RedisManagerBundle\Attribute;

#[\Attribute]
class EncodeOptions
{
    const
        FORMAT_JSON = 'json',
        FORMAT_PLAIN = 'plain';

    public function __construct(
        public string $format = self::FORMAT_JSON,
        public ?string $property = null,
    ) {}
}
