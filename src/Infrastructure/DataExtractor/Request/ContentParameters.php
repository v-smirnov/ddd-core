<?php

namespace vsmirnov\DDDCore\Infrastructure\DataExtractor\Request;

use Symfony\Component\HttpFoundation\Request;
use vsmirnov\DDDCore\Infrastructure\DataExtractor\DataExtractorInterface;
use vsmirnov\DDDCore\Infrastructure\DataExtractor\Decorator;

class ContentParameters extends Base
{
    use Decorator;

    /**
     * @param DataExtractorInterface $decoratedExtractor
     */
    public function __construct(DataExtractorInterface $decoratedExtractor)
    {
        $this->setDecoratedExtractor($decoratedExtractor);
    }

    /**
     * {@inheritdoc}
     */
    protected function extractFromRequest(Request $httpRequest): array
    {
        return $this->decoratedExtractor->extract($httpRequest->getContent());
    }
}
