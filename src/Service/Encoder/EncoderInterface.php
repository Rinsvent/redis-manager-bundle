<?php

namespace Rinsvent\RedisManagerBundle\Service\Encoder;

use Rinsvent\RedisManagerBundle\Attribute\EncodeOptions;

interface EncoderInterface
{
    public function encode(object $object, EncodeOptions $encodeOptions): string;
    public function decode(object $object, string $data, EncodeOptions $encodeOptions): object;
}
