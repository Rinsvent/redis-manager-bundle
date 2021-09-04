<?php

namespace Rinsvent\RedisManagerBundle\Tests;

use Predis\Client;
use Rinsvent\RedisManagerBundle\Service\RedisHelperService;

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
    public function grabRedisHelperService()
    {
        $client = new Client('tcp://redis_managerbundle_redis:6379?password=password123');
        return new RedisHelperService($client);
    }
}
