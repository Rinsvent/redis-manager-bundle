<?php

namespace Rinsvent\RedisManagerBundle\Tests\unit\Service\Encoder\PlainEncoder;


use Rinsvent\RedisManagerBundle\Service\Encoder\PlainEncoder;
use Rinsvent\RedisManagerBundle\Tests\unit\Service\Encoder\PlainEncoder\data\DTO\Test;
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
        $data = $encoder->encode($test, new EncodeOptions(PlainEncoder::FORMAT, 'lastname'));
        $this->assertEquals('lastname', $data);
    }

    public function testJsonDecoder()
    {
        $encoder = $this->tester->grabEncoderService();
        $test = new Test();
        $test->name = 'name';

        $data = $encoder->decode($test, 'lastname2', new EncodeOptions(PlainEncoder::FORMAT, 'lastname'));

        $expectedData = new Test();
        $expectedData->name = 'name';
        $expectedData->lastname = 'lastname2';

        $this->assertEquals($expectedData, $data);
    }
}
