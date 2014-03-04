<?php

namespace Gn\Api\Domain;

/**
 * Title
 */
class Title
{

    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * @param string $value
     */
    protected function setValue($value)
    {
        $this->validateValue($value);
        $this->value = $value;
    }

    /**
     * @param string $value
     * @throws InvalidTitleException
     */
    protected function validateValue($value)
    {
        if (is_string($value) === false) {
            throw new InvalidTitleException('Title should be of type String');
        }
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
