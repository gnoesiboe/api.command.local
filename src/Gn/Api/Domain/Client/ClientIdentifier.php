<?php

namespace Gn\Api\Domain\Client;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

/**
 * ClientIdentifier
 */
class ClientIdentifier
{

    /**
     * @var int
     */
    const VALUE_MIN_LENGTH = 3;

    /**
     * @var int
     */
    const VALUE_MAX_LENGTH = 50;

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
     * @throws ClientIdentifierInvalidException
     */
    private function validateValue($value)
    {
        if (is_string($value) === false) {
            throw new ClientIdentifierInvalidException('Value should be of type string');
        }

        $notBlankConstraint = new NotBlank();

        $lengthConstraint = new Length(array(
            'min' => self::VALUE_MIN_LENGTH,
            'max' => self::VALUE_MAX_LENGTH
        ));

        $violations = Validation::createValidator()->validateValue($value, array(
            $notBlankConstraint,
            $lengthConstraint
        ));

        if ($violations->count() !== 0) {
            throw new ClientIdentifierInvalidException(sprintf(
                'Value should have a minimal length of %d and a max of %d characters',
                self::VALUE_MIN_LENGTH,
                self::VALUE_MAX_LENGTH
            ));
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
