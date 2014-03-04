<?php

namespace Gn\Api\Domain\Permission;

use Gn\Api\Domain\SingleValueObjectInterface;

/**
 * PermissionIdentifier
 */
class PermissionIdentifier implements SingleValueObjectInterface
{

    /**
     * @var string
     */
    private $value;

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
    private function setValue($value)
    {
        $this->validateValue($value);
        $this->value = $value;
    }

    /**
     * @param string $value
     * @throws \UnexpectedValueException
     */
    private function validateValue($value)
    {
        if (is_string($value) === false) {
            throw new \UnexpectedValueException('Value should be of type string');
        }
    }

    /**
     * @param PermissionIdentifier $permissionIdentifier
     * @return bool
     */
    public function is(PermissionIdentifier $permissionIdentifier)
    {
        return $permissionIdentifier->getValue() === $this->getValue();
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->value;
    }
}
