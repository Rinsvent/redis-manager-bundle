<?php

namespace Rinsvent\RedisManagerBundle\Tests\Service\RedisHelperService;


use Rinsvent\RedisManagerBundle\Exception\Lock;

class LockableTest extends \Codeception\Test\Unit
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
    public function testLockable()
    {
        $rhs = $this->tester->grabRedisHelperService();

        $rhs->lock('key9', 1);

        $this->expectException(Lock::class);
        $test = 2;
        $rhs->lockable(function () use (&$test) {
            $test = 5;
        }, 'key9', [], 1);

        $this->assertEquals(2, $test);
    }
}
