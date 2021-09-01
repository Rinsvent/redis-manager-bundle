<?php

namespace Rinsvent\RedisManagerBundle\Attribute;

#[\Attribute]
class Ttl
{
    public function __construct(
        public int $seconds = 60
    ) {}
}
