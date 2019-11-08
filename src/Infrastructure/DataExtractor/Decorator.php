<?php

namespace vsmirnov\DDDCore\Infrastructure\DataExtractor;

trait Decorator
{
    /**
     * @var DataExtractorInterface
     */
    private $decoratedExtractor;

    /**
     * @param DataExtractorInterface $decoratedExtractor
     *
     * @return static
     */
    public function setDecoratedExtractor(DataExtractorInterface $decoratedExtractor)
    {
        $this->decoratedExtractor = $decoratedExtractor;

        return $this;
    }
}
