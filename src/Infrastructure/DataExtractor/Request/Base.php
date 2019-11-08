<?php

namespace vsmirnov\DDDCore\Infrastructure\DataExtractor\Request;

use Symfony\Component\HttpFoundation\Request;
use vsmirnov\DDDCore\Infrastructure\DataExtractor\DataExtractorInterface;

abstract class Base implements DataExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    final public function extract($extractable): array
    {
        return $this->extractFromRequest($extractable);
    }

    /**
     * @param Request $httpRequest
     *
     * @return mixed[]
     */
    abstract protected function extractFromRequest(Request $httpRequest): array;
}
