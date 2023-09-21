<?php

declare(strict_types=1);

namespace Scc\KeyValueFormBundle\Form\Type;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class HashToKeyValueArrayTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform(mixed $value): array
    {
        $return = [];

        foreach ($value as $data) {
            if (['key', 'value'] !== array_keys($data)) {
                throw new TransformationFailedException;
            }

            if (array_key_exists($data['key'], $return)) {
                throw new TransformationFailedException('Duplicate key detected');
            }

            $return[$data['key']] = $data['value'];
        }

        return $return;
    }
}
