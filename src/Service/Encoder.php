<?php

namespace Rinsvent\RedisManagerBundle\Service;

use Rinsvent\RedisManagerBundle\Attribute\EncodeOptions;
use Symfony\Component\DependencyInjection\ServiceLocator;

class Encoder
{
    public function __construct(
        private ServiceLocator $encoderLocator
    ) {}

    public function encode(object $object, EncodeOptions $encodeOptions): string
    {
        $encoder = $this->encoderLocator->get('redis.encoder.' . $encodeOptions->format);
        return $encoder->encode($object, $encodeOptions);
    }

    public function decode(object $object, string $data, EncodeOptions $encodeOptions): object
    {
        $encoder = $this->encoderLocator->get('redis.encoder.' . $encodeOptions->format);
        return $encoder->decode($object, $data, $encodeOptions);
    }
}
