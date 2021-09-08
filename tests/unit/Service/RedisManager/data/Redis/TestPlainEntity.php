<?php

namespace Rinsvent\RedisManagerBundle\Tests\unit\Service\RedisManager\data\Redis;

use Rinsvent\RedisManagerBundle\Attribute\EncodeOptions;
use Rinsvent\RedisManagerBundle\Attribute\Key;
use Rinsvent\RedisManagerBundle\Attribute\Ttl;

#[Ttl(seconds: 5)]
#[Key(path: 'test-entity:{$name}_{$surname}')]
#[EncodeOptions(format: EncodeOptions::FORMAT_PLAIN, property: 'age')]
class TestPlainEntity
{
    public string $name;
    public string $surname;
    public int $age;

    public function __construct(string $name, string $surname)
    {
        $this->name = $name;
        $this->surname = $surname;
    }
}
