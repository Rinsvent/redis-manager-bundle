<?php

namespace Rinsvent\RedisManagerBundle\Service\Encoder;

use Rinsvent\RedisManagerBundle\Attribute\EncodeOptions;

class PlainEncoder
{
    public function encode(object $object, EncodeOptions $encodeOptions): string
    {
        return $object->{'get' . ucfirst($encodeOptions->property)}();
    }

    public function decode(object $object, string $data, EncodeOptions $encodeOptions): object
    {
        $object->{'set' . ucfirst($encodeOptions->property)}($data);
        return $object;
    }
}
