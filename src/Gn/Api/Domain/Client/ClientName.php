<?php

namespace Gn\Api\Domain\Client;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Validation;

/**
 * ClientName
 */
class ClientName
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

        $violations = Validation::createValidator()->validateValue($value, new Length(array('min' => 1, 'max' => 100)));

        if ($violations->count() !== 0) {
            throw new \UnexpectedValueException('Value should have a minimal length of 1 and a max of 100 characters');
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
