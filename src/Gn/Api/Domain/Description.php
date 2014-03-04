<?php

namespace Gn\Api\Domain;

/**
 * Description
 */
class Description
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
     * @throws InvalidDescriptionException
     */
    protected function validateValue($value)
    {
        if (is_string($value) === false) {
            throw new InvalidDescriptionException('Description should be of type String');
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
