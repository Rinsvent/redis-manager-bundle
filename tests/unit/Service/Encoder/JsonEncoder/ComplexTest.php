<?php

namespace Rinsvent\RedisManagerBundle\Tests\unit\Service\Encoder\JsonEncoder;


use Rinsvent\RedisManagerBundle\Tests\unit\Service\Encoder\JsonEncoder\data\DTO\Test;
use Rinsvent\RedisManagerBundle\Attribute\EncodeOptions;

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
    public function testJsonEncoder()
    {
        $encoder = $this->tester->grabEncoderService();
        $test = new Test();
        $test->name = 'name';
        $test->lastname = 'lastname';
        $test->surname = 'surname';
        $data = $encoder->encode($test, new EncodeOptions('json'));
        $this->assertEquals('{"name":"name","lastname":"lastname"}', $data);
    }
}
