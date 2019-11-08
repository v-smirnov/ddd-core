<?php

namespace vsmirnov\DDDCore;

use vsmirnov\DDDCore\Dto\DtoInterface;
use vsmirnov\DDDCore\Dto\EmptyDto;

final class Composite implements ExecutableInterface
{
    /**
     * @var ExecutableInterface[]
     */
    private $executableList;

    /**
     * @param ExecutableInterface[] $executableList
     */
    public function __construct(array $executableList)
    {
        $this->executableList = $executableList;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(DtoInterface $dto): DtoInterface
    {
        foreach ($this->executableList as $executable) {
            $executable->execute($dto);
        }

        return new EmptyDto();
    }
}