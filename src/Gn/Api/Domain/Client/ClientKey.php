<?php

namespace Gn\Api\Domain\Client;

use Gn\Api\Domain\SingleValueObjectInterface;
use Symfony\Component\Validator\Constraints\Length;
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
     * @var string
     */
    const MIN_LENGTH = 40;

    /**
     * @var string
     */
    const MAX_LENGTH = 40;

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

        $violations = Validation::createValidator()->validateValue($value, new Length(array('min' => self::MIN_LENGTH, 'max' => self::MAX_LENGTH)));

        if ($violations->count() !== 0) {
            throw new ClientKeyInvalidException(sprintf('ClientKey Value should have a minimal length of %s and a max of %s characters', self::MIN_LENGTH, self::MAX_LENGTH));
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
