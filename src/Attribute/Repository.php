<?php

namespace Rinsvent\RedisManagerBundle\Attribute;

#[\Attribute]
class Repository
{
    public function __construct(
        public string $class
    ) {}
}
