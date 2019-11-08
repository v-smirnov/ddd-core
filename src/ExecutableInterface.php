<?php

namespace vsmirnov\DDDCore;

use vsmirnov\DDDCore\Dto\DtoInterface;
use vsmirnov\DDDCore\Exception\ExecutionException;

interface ExecutableInterface
{
    /**
     * @param DtoInterface $dto
     *
     * @return DtoInterface
     * @throws ExecutionException
     */
    public function execute(DtoInterface $dto): DtoInterface;
}