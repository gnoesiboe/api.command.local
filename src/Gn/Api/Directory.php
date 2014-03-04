<?php

namespace Gn\Api;

use Gn\Api\Domain\SingleValueObjectInterface;

/**
 * Directory
 */
class Directory implements SingleValueObjectInterface
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
     * @throws \UnexpectedValueException
     */
    protected function validateValue($value)
    {
        if (is_string($value) === false) {
            throw new \UnexpectedValueException('value should be of type string');
        }

        if (file_exists($value) === false || is_dir($value) === false) {
            throw new \UnexpectedValueException('No directory exists with path: ' . $value);
        }
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
