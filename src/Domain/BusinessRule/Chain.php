<?php

namespace vsmirnov\DDDCore\Domain\BusinessRule;

use vsmirnov\DDDCore\Dto\DtoInterface;
use vsmirnov\DDDCore\Domain\BusinessRule\CheckResult\CheckResult;
use vsmirnov\DDDCore\Domain\BusinessRule\CheckResult\SuccessfulCheck;

final class Chain implements BusinessRuleInterface
{
    /**
     * @var BusinessRuleInterface[]
     */
    private $businessRuleList;

    /**
     * @param BusinessRuleInterface[] $businessRuleList
     */
    public function __construct(array $businessRuleList)
    {
        $this->businessRuleList = $businessRuleList;
    }

    /**
     * {@inheritdoc}
     */
    public function check(DtoInterface $dto): CheckResult
    {
        foreach ($this->businessRuleList as $businessRule) {
            $checkResult = $businessRule->check($dto);

            if ($checkResult->isErroneous()) {
                return $checkResult;
            }
        }

        return new SuccessfulCheck();
    }
}