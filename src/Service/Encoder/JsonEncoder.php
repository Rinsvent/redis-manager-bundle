<?php

namespace Rinsvent\RedisManagerBundle\Service\Encoder;

use Rinsvent\RedisManagerBundle\Attribute\EncodeOptions;

class JsonEncoder
{
    public function encode(object $object, EncodeOptions $encodeOptions): string
    {
        $result = [];
        $properties = $encodeOptions->fields;
        foreach ($properties as $propertyName) {
            $result[$propertyName] = $object->{'get' . ucfirst($propertyName)}();
        }
        return json_encode($result);
    }

    public function decode(object $object, string $data, EncodeOptions $encodeOptions): object
    {
        $data = json_decode($data, true);
        $properties = $encodeOptions->fields;
        foreach ($properties as $propertyName) {
            $object->{'set' . ucfirst($propertyName)}($data[$propertyName]);
        }
        return $object;
    }
}
