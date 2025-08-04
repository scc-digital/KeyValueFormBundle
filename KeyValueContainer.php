<?php

namespace Scc\KeyValueFormBundle;

class KeyValueContainer implements \ArrayAccess
{
    private $data;

    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet($offset): mixed
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }
}
