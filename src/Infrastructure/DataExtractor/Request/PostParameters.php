<?php

namespace vsmirnov\DDDCore\Infrastructure\DataExtractor\Request;

use Symfony\Component\HttpFoundation\Request;

class PostParameters extends Base
{
    /**
     * {@inheritdoc}
     */
    protected function extractFromRequest(Request $httpRequest): array
    {
        return $httpRequest->request->all();
    }
}
