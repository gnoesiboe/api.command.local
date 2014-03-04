<?php

namespace Gn\Test\Api\Domain\Client;

use Gn\Api\Domain\Client\ClientIdentifier;
use Gn\Test;

/**
 * ClientIdentifierTest
 */
class ClientIdentifierTest extends Test
{

    /**
     * @var string
     */
    protected $clientIdentifierInvalidExceptionClassName = '\Gn\Api\Domain\Client\ClientIdentifierInvalidException';

    /**
     * The value object should only allow string values
     */
    public function testOnlyAcceptsAStringValue()
    {
        $someInt = 3923;
        $someFloat = 22.4;
        $someObject = new \stdClass();
        $someBool = true;
        $someString = sha1('39230239323');

        try {
            new ClientIdentifier($someInt);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientIdentifierInvalidExceptionClassName, $e);
        }

        try {
            new ClientIdentifier($someFloat);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientIdentifierInvalidExceptionClassName, $e);
        }

        try {
            new ClientIdentifier($someObject);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientIdentifierInvalidExceptionClassName, $e);
        }

        try {
            new ClientIdentifier($someBool);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientIdentifierInvalidExceptionClassName, $e);
        }

        // should not trigger exception
        new ClientIdentifier($someString);
    }

    /**
     * The value object should only allow strings within a specific length range
     */
    public function testOnlyAcceptsAStringValueWithALengthBetween1And50Characters()
    {
        $toShort = str_repeat('x', ClientIdentifier::VALUE_MIN_LENGTH - 1);
        $toLong = str_repeat('x', ClientIdentifier::VALUE_MAX_LENGTH + 1);
        $justRight = 'some_identifier';

        try {
            new ClientIdentifier($toShort);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientIdentifierInvalidExceptionClassName, $e);
        }

        try {
            new ClientIdentifier($toLong);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientIdentifierInvalidExceptionClassName, $e);
        }

        // should not trigger an exception
        new ClientIdentifier($justRight);
    }

    /**
     * The value object's value should be the value that was added in the first place
     */
    public function testGetValueReturnsTheValueThatWasAdded()
    {
        $value = 'abcdefghij';

        $identifier = new ClientIdentifier($value);
        $this->assertTrue($identifier->getValue() === $value);
    }
}
