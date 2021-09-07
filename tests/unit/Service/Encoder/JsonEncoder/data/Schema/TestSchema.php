<?php

namespace Rinsvent\RedisManagerBundle\Tests\unit\Service\Encoder\JsonEncoder\data\Schema;

use Rinsvent\DTO2Data\Attribute\Schema;

#[\Attribute(\Attribute::TARGET_CLASS)]
class TestSchema extends Schema
{
    public ?array $baseMap = [
        'name',
        'lastname',
    ];
}
