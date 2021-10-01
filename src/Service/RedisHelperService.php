<?php

namespace Rinsvent\RedisManagerBundle\Service;

use Predis\Client;
use Rinsvent\RedisManagerBundle\Exception\Lock;

class RedisHelperService
{
    const TTL = 60; // minute
    const PREFIX = 'rinsvent:';

    private Client $rc;

    public function __construct(Client $rc)
    {
        $this->rc = $rc;
    }

    public function lock(string $key, ?int $seconds = null): void
    {
        if (!$this->rc->set($this->getKey($key), 1, 'EX', $seconds ?? self::TTL, 'NX')) {
            throw new Lock();
        }
    }

    public function unlock(string $key): void
    {
        $this->rc->del($this->getKey($key));
    }

    public function lockable(callable $callback, string $key, array $arguments = [], ?int $seconds = null): mixed
    {
        try {
            $this->lock($key, $seconds);
            return call_user_func_array($callback, $arguments);
        } catch (Lock $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->unlock($key);
            throw $e;
        }
    }

    public function set(string $name, string $value, ?int $seconds = null): void
    {
        $this->rc->set($this->getKey($name), $value, 'EX', $seconds ?? self::TTL);
    }

    public function get(string $name): ?string
    {
        return $this->rc->get($this->getKey($name));
    }

    private function getKey(string $key): string
    {
        return self::PREFIX . $key;
    }
}
