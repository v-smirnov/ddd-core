<?php

namespace vsmirnov\DDDCore\Infrastructure\Transformer\HttpRequest;

use Symfony\Component\HttpFoundation\Request;
use vsmirnov\DDDCore\Dto\DtoInterface;
use vsmirnov\DDDCore\Infrastructure\DataExtractor\DataExtractorInterface;
use vsmirnov\DDDCore\Infrastructure\ObjectBuilder\ObjectBuilderInterface;

final class HttpRequestToDtoTransformer implements HttpRequestToDtoTransformerInterface
{
    /**
     * @var DataExtractorInterface
     */
    private $dataExtractor;

    /**
     * @var ObjectBuilderInterface
     */
    private $objectBuilder;

    /**
     * @var string
     */
    private $dtoClass;

    /**
     * @param DataExtractorInterface $dataExtractor
     * @param ObjectBuilderInterface $objectBuilder
     * @param string $dtoClass
     */
    public function __construct(DataExtractorInterface $dataExtractor, ObjectBuilderInterface $objectBuilder, string $dtoClass)
    {
        $this->dataExtractor = $dataExtractor;
        $this->objectBuilder = $objectBuilder;
        $this->dtoClass = $dtoClass;
    }

    /**
     * {@inheritdoc}
     */
    public function transform(Request $httpRequest): DtoInterface
    {
        return $this->objectBuilder->build($this->dtoClass, $this->dataExtractor->extract($httpRequest));
    }
}