<?php

namespace Rinsvent\RedisManagerBundle\Attribute;

#[\Attribute]
class EncodeOptions
{
    const
        FORMAT_JSON = 'json',
        FORMAT_PLAIN = 'plain',
        TARGET_PROPERTY = 'property',
        TARGET_FIELDS = 'fields';

    public function __construct(
        public string $format = self::FORMAT_JSON,
        public string $target = self::TARGET_FIELDS,
        public ?string $property = null,
        public array $fields = [],
    ) {}
}
