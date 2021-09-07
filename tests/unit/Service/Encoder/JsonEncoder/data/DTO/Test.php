<?php

namespace Rinsvent\RedisManagerBundle\Tests\unit\Service\Encoder\JsonEncoder\data\DTO;

use Rinsvent\RedisManagerBundle\Tests\unit\Service\Encoder\JsonEncoder\data\Schema\TestSchema;

#[TestSchema]
class Test
{
    public string $name;
    public string $surname;
    public string $lastname;
    public string $age;
}
