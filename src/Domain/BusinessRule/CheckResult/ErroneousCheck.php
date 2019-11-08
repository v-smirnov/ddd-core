<?php

namespace vsmirnov\DDDCore\Domain\BusinessRule\CheckResult;

final class ErroneousCheck extends CheckResult
{
    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct(false, $message);
    }
}