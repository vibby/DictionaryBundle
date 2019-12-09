<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;
use Traversable;

/**
 * @template E
 * @implements Dictionary<E>
 */
final class Iterator implements Dictionary
{
    use Traits\Wrapper;

    /**
     * @param Traversable<mixed, mixed> $iterator
     */
    public function __construct(string $name, Traversable $iterator)
    {
        $this->dictionary = new Invokable($name, function () use ($iterator): array {
            return iterator_to_array($iterator);
        });
    }
}
