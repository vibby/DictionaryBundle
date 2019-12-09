<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use ArrayIterator;
use Knp\DictionaryBundle\Dictionary;

/**
 * @template E
 * @implements Dictionary<E>
 */
final class Simple implements Dictionary
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array<mixed, mixed>
     */
    private $values = [];

    /**
     * @param array<mixed, mixed> $values
     */
    public function __construct(string $name, array $values)
    {
        $this->name   = $name;
        $this->values = $values;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getKeys(): array
    {
        return array_keys($this->values);
    }

    public function offsetExists($offset): bool
    {
        return \array_key_exists($offset, $this->values);
    }

    public function offsetGet($offset)
    {
        return $this->values[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->values[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->values[$offset]);
    }

    /**
     * @return ArrayIterator<mixed, E>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->values);
    }

    public function count(): int
    {
        return \count($this->values);
    }
}
