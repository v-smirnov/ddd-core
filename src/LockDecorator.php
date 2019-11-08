<?php

namespace vsmirnov\DDDCore;

use Exception;
use Symfony\Component\Lock\Factory;
use vsmirnov\DDDCore\Dto\DtoInterface;
use vsmirnov\DDDCore\Dto\EmptyDto;

final class LockDecorator implements ExecutableInterface
{
    /**
     * @var ExecutableInterface
     */
    private $decoratedService;

    /**
     * @var Factory
     */
    private $lockFactory;

    /**
     * @var string;
     */
    private $lockKey;

    /**
     * @var int
     */
    private $lockTtl;

    /**
     * @param ExecutableInterface $decoratedService
     * @param Factory $lockFactory
     * @param string $lockKey
     * @param int $lockTtl
     */
    public function __construct(
        ExecutableInterface $decoratedService,
        Factory $lockFactory,
        string $lockKey,
        int $lockTtl
    ) {
        $this->decoratedService = $decoratedService;
        $this->lockFactory = $lockFactory;
        $this->lockKey = $lockKey;
        $this->lockTtl = $lockTtl;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(DtoInterface $dto): DtoInterface
    {
        $lock = $this->lockFactory->createLock($this->lockKey, $this->lockTtl);

        if ($lock->acquire()) {
            try {
                $result = $this->decoratedService->execute($dto);
            } catch (Exception $e) {
                $lock->release();

                throw $e;
            }

            $lock->release();

            return $result;
        }

        return new EmptyDto();
    }
}