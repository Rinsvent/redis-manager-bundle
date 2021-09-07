<?php

namespace Rinsvent\RedisManagerBundle\Service\Encoder;

use Rinsvent\Data2DTO\Data2DtoConverter;
use Rinsvent\DTO2Data\Dto2DataConverter;
use Rinsvent\RedisManagerBundle\Attribute\EncodeOptions;

class JsonEncoder extends AbstractEncoder
{
    public const FORMAT = 'json';

    public function encode(object $object, EncodeOptions $encodeOptions): string
    {
        $dto2dataConverter = new Dto2DataConverter();
        $result = $dto2dataConverter->convert($object);
        return json_encode($result);
    }

    public function decode(object $object, string $data, EncodeOptions $encodeOptions): object
    {
        $data = json_decode($data, true);
        $data2DTOConverter = new Data2DtoConverter();
        return $data2DTOConverter->convert($data, $object);
    }
}
