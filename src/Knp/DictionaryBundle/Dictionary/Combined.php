<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\Dictionary;

use Knp\DictionaryBundle\Dictionary;

/**
 * @template E
 * @implements Dictionary<E>
 */
final class Combined implements Dictionary
{
    use Traits\Wrapper;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array<int, Dictionary<E>>
     */
    private $dictionaries = [];

    /**
     * @param array<int, Dictionary<E>> $dictionaries
     */
    public function __construct(string $name, Dictionary ...$dictionaries)
    {
        $this->dictionary = new Invokable($name, function () use ($dictionaries): array {
            $data = [];

            foreach ($dictionaries as $dictionary) {
                $data = $this->merge($data, iterator_to_array($dictionary));
            }

            return $data;
        });
    }

    /**
     * @param mixed[] $array1
     * @param mixed[] $array2
     *
     * @return mixed[]
     */
    private function merge(array $array1, array $array2): array
    {
        if ($array1 === array_values($array1) && $array2 === array_values($array2)) {
            return array_merge($array1, $array2);
        }

        $data = [];

        foreach ([$array1, $array2] as $array) {
            foreach ($array as $key => $value) {
                $data[$key] = $value;
            }
        }

        return $data;
    }
}
