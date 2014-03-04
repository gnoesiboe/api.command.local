<?php

namespace Gn\Api\Domain\Client;

use Gn\Api\Domain\SingleValueObjectInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

/**
 * ClientKey
 */
class ClientKey implements ClientKeyInterface
{

    /**
     * @var string
     */
    private $value;

    /**
     * @var int
     */
    const SUPPORTED_LENGTH = 40;

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
     * @throws ClientKeyInvalidException
     */
    private function validateValue($value)
    {
        if (is_string($value) === false) {
            throw new ClientKeyInvalidException('Client key value should be of type string');
        }

        $constraints = array(
            new NotBlank(),
            new Length(array('min' => self::SUPPORTED_LENGTH, 'max' => self::SUPPORTED_LENGTH))
        );

        $violations = Validation::createValidator()->validateValue($value, $constraints);

        if ($violations->count() !== 0) {
            throw new ClientKeyInvalidException(sprintf('ClientKey Value should have a length of %s characters', self::SUPPORTED_LENGTH));
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
