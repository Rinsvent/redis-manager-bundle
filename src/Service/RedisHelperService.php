<?php

namespace Rinsvent\RedisManagerBundle\Service;

use Predis\Client;
use Rinsvent\RedisManagerBundle\Exception\Lock;

class RedisHelperService
{
    const TTL = 3600; // hour

    private Client $rc;

    public function __construct(Client $rc)
    {
        $this->rc = $rc;
    }

    public function lock(string $key, ?int $seconds = null)
    {
        if (!$this->rc->set($key, 1, 'EX', $seconds ?? self::TTL, 'NX')) {
            throw new Lock();
        }
    }

    public function set(string $name, string $value, ?int $seconds = null): void
    {
        $this->rc->set($name, $value, 'EX', $seconds ?? self::TTL);
    }

    public function get(string $name): ?string
    {
        return $this->rc->get($name);
    }
}
