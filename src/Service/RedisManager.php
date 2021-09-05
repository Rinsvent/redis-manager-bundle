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
        $this->toPersist[$object::class][$key] = $object;
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
            }
        }
    }

    public function find(object $object): ?object
    {
        /** @var Key $ttl */
        $key = (new ClassExtractor($object::class))->fetch(Key::class);
        $key = $this->keyFiller->fill($key->path, $object);
        if ($data = $this->rc->get($key)) {
            /** @var EncodeOptions $encodeOptions */
            if (!$encodeOptions = (new ClassExtractor($object::class))->fetch(EncodeOptions::class)) {
                throw new \Exception('EncodeOptions meta info not found');
            }
            return $this->encoder->decode($object, $data, $encodeOptions);
        }
        return null;
    }
}
