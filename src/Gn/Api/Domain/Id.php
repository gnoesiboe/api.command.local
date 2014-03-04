<?php

namespace Gn\Api\Domain;

/**
 * Id
 */
class Id
{

    /**
     * @var int
     */
    protected $value;

    /**
     * @param int $value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * @param int $value
     */
    protected function setValue($value)
    {
        $this->validateValue($value);
        $this->value = $value;
    }

    /**
     * @param int $value
     */
    protected function validateValue($value)
    {
        if (is_int($value) === false) {
            $this->throwInvalidValueException($value);
        }
    }

    /**
     * @param mixed $value
     * @throws InvalidIdException
     */
    protected function throwInvalidValueException($value)
    {
        throw new InvalidIdException();
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }
}
