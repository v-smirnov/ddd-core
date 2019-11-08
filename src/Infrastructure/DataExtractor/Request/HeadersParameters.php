<?php

namespace vsmirnov\DDDCore\Infrastructure\DataExtractor\Request;

use Symfony\Component\HttpFoundation\Request;

class HeadersParameters extends Base
{
    /**
     * {@inheritdoc}
     */
    protected function extractFromRequest(Request $httpRequest): array
    {
        return
            array_map(
                function ($headerValue) {
                    return
                        is_array($headerValue) && count($headerValue) === 1
                            ? array_shift($headerValue)
                            : $headerValue;
                },
                $httpRequest->headers->all()
            );
    }
}
