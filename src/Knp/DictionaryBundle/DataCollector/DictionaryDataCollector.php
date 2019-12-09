<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DataCollector;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class DictionaryDataCollector extends DataCollector
{
    public function collect(Request $request, Response $response, Exception $exception = null): void
    {
    }

    /**
     * @param mixed[] $keys
     * @param mixed[] $values
     */
    public function addDictionary(string $name, array $keys, array $values): void
    {
        $this->data[$name] = array_map(
            function ($key, $value): array {
                return ['key' => $key, 'value' => $value];
            },
            $keys,
            $values,
        );
    }

    /**
     * @return iterable<array<string, mixed>>
     */
    public function getDictionaries(): iterable
    {
        return $this->data;
    }

    public function reset(): void
    {
    }

    public function getName()
    {
        return 'dictionary';
    }
}
