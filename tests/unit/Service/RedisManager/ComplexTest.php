<?php

namespace Rinsvent\RedisManagerBundle\Tests\Service\RedisManager;


use Rinsvent\RedisManagerBundle\Tests\unit\Service\RedisManager\data\Redis\TestPlainEntity;

class ComplexTest extends \Codeception\Test\Unit
{
    /**
     * @var \Rinsvent\RedisManagerBundle\Tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSuccessFlush()
    {
        $client = $this->tester->grabClient();
        $rm = $this->tester->grabRedisManager();

        $data = new TestPlainEntity('igor', 'sipachev');
        $data->age = 29;
        $rm->persist($data);
        $rm->flush();

        $actualValue = $client->get('test-entity:igor_sipachev');
        $this->assertEquals(29, $actualValue);
    }

    public function testFind()
    {
        $client = $this->tester->grabClient();
        $client->set('test-entity:igor_sipachev', 30);

        $rm = $this->tester->grabRedisManager();

        $data = new TestPlainEntity('igor', 'sipachev');
        $data = $rm->find($data);

        $expectedData = new TestPlainEntity('igor', 'sipachev');
        $expectedData->age = 30;
        $this->assertEquals($expectedData, $data);
    }
}
