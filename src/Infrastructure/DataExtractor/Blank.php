<?php

namespace vsmirnov\DDDCore\Infrastructure\DataExtractor;

final class Blank implements DataExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function extract($extractable): array
    {
        return [];
    }
}
