<?php

namespace Rinsvent\RedisManagerBundle\Service;

use Rinsvent\RedisManagerBundle\Attribute\EncodeOptions;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Encoder
{
    public function __construct(
        private ContainerInterface $container
    ) {}

    /**
     * @param object $object
     * @return string
     */
    public function encode(object $object, EncodeOptions $encodeOptions): string
    {
        $encoder = $this->container->get('redis.encoder.' . $encodeOptions->format);
        return $encoder->encode($object, $encodeOptions);
    }

    /**
     * @param object $object
     * @param string $data
     * @return object
     * @throws \ReflectionException
     */
    public function decode(object $object, string $data, EncodeOptions $encodeOptions): object
    {
        $encoder = $this->container->get('redis.encoder.' . $encodeOptions->format);
        return $encoder->decode($object, $data, $encodeOptions);
    }
}
