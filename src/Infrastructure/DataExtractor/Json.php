<?php

namespace vsmirnov\DDDCore\Infrastructure\DataExtractor;

final class Json implements DataExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function extract($extractable): array
    {
        return (array) json_decode($extractable, true);
    }
}
