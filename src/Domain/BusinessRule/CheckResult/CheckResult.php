<?php

namespace vsmirnov\DDDCore\Domain\BusinessRule\CheckResult;

abstract class CheckResult
{
    /**
     * @var bool
     */
    protected $result;

    /**
     * @var string
     */
    protected $message;

    /**
     * @param bool $result
     * @param string $message
     */
    public function __construct(bool $result, string $message = '')
    {
        $this->result = $result;
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->result === true;
    }

    /**
     * @return bool
     */
    public function isErroneous(): bool
    {
        return $this->result === false;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}