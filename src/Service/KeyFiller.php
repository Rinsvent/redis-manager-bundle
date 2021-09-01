<?php

namespace Rinsvent\RedisManagerBundle\Service;

class KeyFiller
{
    public function fill(string $key, object $object): string
    {
        if (preg_match_all('#\{\$(.*?)\}#', $key, $matches)) {
            $marks = $matches[0] ?? [];
            foreach ($marks as $index => $mark) {
                $markCode = $matches[1][$index] ?? null;
                $markValue = $object->{'get' . ucfirst($markCode)}();
                $key = strtr($key, [
                    $mark => $markValue
                ]);
            }
        }
        return $key;
    }
}
