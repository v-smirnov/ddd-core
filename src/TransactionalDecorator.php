<?php

namespace vsmirnov\DDDCore;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use vsmirnov\DDDCore\Dto\DtoInterface;

final class TransactionalDecorator implements ExecutableInterface
{
    /**
     * @var EntityManagerInterface[]
     */
    private $entityManagerList;

    /**
     * @var ExecutableInterface
     */
    private $decoratedService;

    /**
     * @param EntityManagerInterface[] $entityManagerList
     * @param ExecutableInterface $decoratedService
     */
    public function __construct(array $entityManagerList, ExecutableInterface $decoratedService)
    {
        $this->entityManagerList = $entityManagerList;
        $this->decoratedService = $decoratedService;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(DtoInterface $dto): DtoInterface
    {
        foreach ($this->entityManagerList as $entityManager) {
            $entityManager->getConnection()->beginTransaction();
        }

        try {
            $result = $this->decoratedService->execute($dto);

            foreach ($this->entityManagerList as $entityManager) {
                $entityManager->flush();
                $entityManager->getConnection()->commit();
            }
        } catch (Exception $e) {
            foreach ($this->entityManagerList as $entityManager) {
                $entityManager->close();
                $entityManager->getConnection()->rollBack();
            }

            throw $e;
        }

        return $result;
    }
}