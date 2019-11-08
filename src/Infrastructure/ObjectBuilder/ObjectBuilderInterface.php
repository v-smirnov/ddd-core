<?php

namespace vsmirnov\DDDCore\Infrastructure\ObjectBuilder;

interface ObjectBuilderInterface
{
    /**
     * @param string $objectClass
     * @param mixed[] $data
     *
     * @return object
     */
    public function build(string $objectClass, array $data);
}
