<?php

namespace Rinsvent\RedisManagerBundle\Attribute;

#[\Attribute]
class Key
{
    public function __construct(
        public string $path
    ) {}
}
