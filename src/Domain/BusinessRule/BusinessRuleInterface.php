<?php

namespace vsmirnov\DDDCore\Domain\BusinessRule;

use vsmirnov\DDDCore\Dto\DtoInterface;
use vsmirnov\DDDCore\Domain\BusinessRule\CheckResult\CheckResult;

interface BusinessRuleInterface
{
    /**
     * @param DtoInterface $dto
     *
     * @return CheckResult
     */
    public function check(DtoInterface $dto): CheckResult;
}