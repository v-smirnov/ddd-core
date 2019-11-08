<?php

namespace vsmirnov\DDDCore\Infrastructure\DataExtractor;

interface DataExtractorInterface
{
    /**
     * @param mixed $extractable
     *
     * @return mixed[]
     */
    public function extract($extractable): array;
}