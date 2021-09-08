<?php

namespace Rinsvent\RedisManagerBundle\Tests;

use Predis\Client;
use Rinsvent\RedisManagerBundle\Service\Encoder;
use Rinsvent\RedisManagerBundle\Service\KeyFiller;
use Rinsvent\RedisManagerBundle\Service\RedisHelperService;
use Rinsvent\RedisManagerBundle\Service\RedisManager;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class UnitTester extends \Codeception\Actor
{
    use _generated\UnitTesterActions;

    /**
     * Define custom actions here
     */
    public function grabClient()
    {
        return new Client('tcp://redis_managerbundle_redis:6379?password=password123');
    }

    public function grabRedisHelperService()
    {
        return new RedisHelperService($this->grabClient());
    }

    public function grabEncoderService()
    {
        $encoderLocator = new ServiceLocator([
            'redis.encoder.json' => function (ServiceLocator $serviceLocator) {
                return new Encoder\JsonEncoder();
            },
            'redis.encoder.plain' => function (ServiceLocator $serviceLocator) {
                return new Encoder\PlainEncoder();
            },
        ]);
        return new Encoder($encoderLocator);
    }

    public function grabRedisManager()
    {
        return new RedisManager($this->grabClient(), $this->grabEncoderService(), new KeyFiller());
    }
}
