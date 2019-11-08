<?php

namespace vsmirnov\DDDCore;

use Psr\Log\LoggerInterface;
use vsmirnov\DDDCore\Dto\DtoInterface;
use vsmirnov\DDDCore\Exception\ExecutionException;
use vsmirnov\DDDCore\Domain\BusinessRule\BusinessRuleInterface;

final class CheckBusinessRuleDecorator implements ExecutableInterface
{
    /**
     * @var ExecutableInterface
     */
    private $decoratedService;

    /**
     * @var BusinessRuleInterface
     */
    private $businessRule;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param ExecutableInterface $decoratedService
     * @param BusinessRuleInterface $businessRule
     * @param LoggerInterface $logger
     */
    public function __construct(
        ExecutableInterface $decoratedService,
        BusinessRuleInterface $businessRule,
        LoggerInterface $logger
    ) {
        $this->decoratedService = $decoratedService;
        $this->businessRule = $businessRule;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(DtoInterface $dto): DtoInterface
    {
        $this->logger->info('Starting to check business rules for executable');

        $checkResult = $this->businessRule->check($dto);
        if ($checkResult->isErroneous()) {
            $this->logger->error($checkResult->getMessage());
            throw new ExecutionException($checkResult->getMessage());
        }

        return $this->decoratedService->performOperation($dto);
    }
}