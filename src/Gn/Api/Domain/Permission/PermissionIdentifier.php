<?php

namespace Gn\Api\Domain\Permission;

use Gn\Api\Domain\SingleValueObjectInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validation;

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
     * @var string
     */
    const MIN_LENGTH = 10;

    /**
     * @var string
     */
    const MAX_LENGTH = 50;

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
     * @throws PermissionIdentifierInvalidException
     */
    private function validateValue($value)
    {
        if (is_string($value) === false) {
            throw new PermissionIdentifierInvalidException('Value should be of type string');
        }

        $constraints = array(
            new NotBlank(),
            new Regex(array(
                'pattern' => '/^[a-z_]+$/'
            )),
            new Length(array(
                'min' => self::MIN_LENGTH,
                'max' => self::MAX_LENGTH
            ))
        );

        $violations = Validation::createValidator()->validateValue($value, $constraints);

        if ($violations->count() > 0) {
            throw new PermissionIdentifierInvalidException(sprintf(
                'Value should consist out of the follow characters: a-z and _ and has a min length of %s and a max length of %s',
                self::MIN_LENGTH,
                self::MAX_LENGTH
            ));
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
