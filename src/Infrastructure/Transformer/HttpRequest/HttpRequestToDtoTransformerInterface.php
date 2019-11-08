<?php

namespace vsmirnov\DDDCore\Infrastructure\Transformer\HttpRequest;

use Symfony\Component\HttpFoundation\Request;
use vsmirnov\DDDCore\Dto\DtoInterface;

interface HttpRequestToDtoTransformerInterface
{
    /**
     * @param Request $httpRequest
     *
     * @return DtoInterface
     */
    public function transform(Request $httpRequest): DtoInterface;
}