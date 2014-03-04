<?php

namespace Gn\Api\Domain\Client;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
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
     * @var int
     */
    const MIN_LENGTH = 1;

    /**
     * @var int
     */
    const MAX_LENGTH = 100;

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
     * @throws ClientNameInvalidException
     */
    private function validateValue($value)
    {
        if (is_string($value) === false) {
            throw new ClientNameInvalidException('Value should be of type string');
        }

        $constraints = array(
            new NotBlank(),
            new Length(array('min' => self::MIN_LENGTH, 'max' => self::MAX_LENGTH))
        );

        $violations = Validation::createValidator()->validateValue($value, $constraints);

        if ($violations->count() !== 0) {
            throw new ClientNameInvalidException(sprintf(
                'Value should have a minimal length of \'%s\' and a max of \'%s\' characters',
                self::MIN_LENGTH,
                self::MAX_LENGTH
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
