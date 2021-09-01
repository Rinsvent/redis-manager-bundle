<?php

namespace Rinsvent\RedisManagerBundle\Service;

use Predis\Client;
use Rinsvent\AttributeExtractor\ClassExtractor;
use Rinsvent\RedisManagerBundle\Attribute\EncodeOptions;
use Rinsvent\RedisManagerBundle\Attribute\Key;
use Rinsvent\RedisManagerBundle\Attribute\Ttl;

class RedisManager
{
    private array $store = [];
    private array $toPersist = [];

    public function __construct(
        private Client $rc,
        private Encoder $encoder,
        private KeyFiller $keyFiller,
    ) {}

    public function persist(object $object): void
    {
        /** @var Key $ttl */
        $key = (new ClassExtractor($object::class))->fetch(Key::class);
        $key = $this->keyFiller->fill($key->path, $object);

        $storeValue = $this->store[$object::class][$key] ?? null;
        $currentValue = $this->toPersist[$object::class][$key] ?? null;
        if (!$storeValue || $storeValue !== $currentValue) {
            $this->toPersist[$object::class][$key] = $object;
        }
        if (!$storeValue) {
            $this->store[$object::class][$key] = $object;
        }
    }

    public function flush()
    {
        foreach ($this->toPersist as $class => $items) {
            /** @var Ttl $ttl */
            $ttl = (new ClassExtractor($class))->fetch(Ttl::class);
            /** @var EncodeOptions $encodeOptions */
            $encodeOptions = (new ClassExtractor($class))->fetch(EncodeOptions::class);
            foreach ($items as $key => $item) {
                $value = $this->encoder->encode($item, $encodeOptions);
                $this->rc->set($key, $value, 'EX', $ttl->seconds);
                $this->putToStore($item);
            }
        }
    }

    protected function putToStore(object $object): void
    {
        /** @var Key $ttl */
        $key = (new ClassExtractor($object::class))->fetch(Key::class);
        $key = $this->keyFiller->fill($key->path, $object);
        $this->store[$object::class][$key] = $object;
    }

    public function getFromStore(object $object): ?object
    {
        /** @var Key $ttl */
        $key = (new ClassExtractor($object::class))->fetch(Key::class);
        $key = $this->keyFiller->fill($key->path, $object);
        return $this->store[$object::class][$key] ?? null;
    }
}
