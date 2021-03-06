<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\ValueTransformer;

use Knp\DictionaryBundle\ValueTransformer;
use ReflectionClass;

final class Constant implements ValueTransformer
{
    /**
     * @var string
     */
    private $pattern = '/^(?P<class>.*)::(?P<constant>.*)$/';

    public function supports($value): bool
    {
        if (!\is_string($value)) {
            return false;
        }

        $matches = [];

        if (0 === preg_match($this->pattern, $value, $matches)) {
            return false;
        }

        if (!class_exists($matches['class']) && !interface_exists($matches['class'])) {
            return false;
        }

        $constants = (new ReflectionClass($matches['class']))
            ->getConstants()
        ;

        return \array_key_exists($matches['constant'], $constants);
    }

    public function transform($value)
    {
        $matches = [];

        preg_match($this->pattern, $value, $matches);

        return (new ReflectionClass($matches['class']))
            ->getConstant($matches['constant'])
        ;
    }
}
