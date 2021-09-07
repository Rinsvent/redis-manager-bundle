<?php

namespace Rinsvent\RedisManagerBundle\Tests\Service\RedisHelperService;


use Rinsvent\RedisManagerBundle\Exception\Lock;

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
    public function testLock()
    {
        $rhs = $this->tester->grabRedisHelperService();
        $rhs->lock('key1', 1);
    }

    public function testDoubleLock()
    {
        $rhs = $this->tester->grabRedisHelperService();
        $rhs->lock('key2', 1);
        $this->expectException(Lock::class);
        $rhs->lock('key2', 1);
    }

    public function testDoubleLockWithDifferentKeys()
    {
        $rhs = $this->tester->grabRedisHelperService();
        $rhs->lock('key3', 1);
        $rhs->lock('key4', 1);
    }

    public function testSetGet()
    {
        $rhs = $this->tester->grabRedisHelperService();
        $rhs->set('key5', 1);
        $value = $rhs->get('key5');
        $this->assertEquals(1, $value);
    }

    public function testGetEmpty()
    {
        $rhs = $this->tester->grabRedisHelperService();
        $value = $rhs->get('key6');
        $this->assertEquals(null, $value);
    }
}
