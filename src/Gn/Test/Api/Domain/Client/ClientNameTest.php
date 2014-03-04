<?php

namespace Gn\Test\Api\Domain\Client;

use Gn\Api\Domain\Client\ClientName;
use Gn\Test;

/**
 * ClientNameTest
 */
class ClientNameTest extends Test
{

    /**
     * @var string
     */
    protected $clientNameInvalidExceptionClassName = '\Gn\Api\Domain\Client\ClientNameInvalidException';

    /**
     * A ClientName should only accept string values
     */
    public function testOnlyStringIsAllowedAsValue()
    {
        $someInt = 3923;
        $someFloat = 22.4;
        $someObject = new \stdClass();
        $someBool = true;
        $someString = sha1('39230239323');

        try {
            new ClientName($someInt);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientNameInvalidExceptionClassName, $e);
        }

        try {
            new ClientName($someFloat);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientNameInvalidExceptionClassName, $e);
        }

        try {
            new ClientName($someObject);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientNameInvalidExceptionClassName, $e);
        }

        try {
            new ClientName($someBool);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientNameInvalidExceptionClassName, $e);
        }

        new ClientName($someString);
    }

    /**
     * The value should be a string with 40 characters
     */
    public function testOnlyAcceptsAStringOf40Characters()
    {
        $stringToShort = str_repeat('x', ClientName::MIN_LENGTH - 1);
        $stringToLong = str_repeat('x', ClientName::MAX_LENGTH + 1);
        $stringJustRight = str_repeat('x', ClientName::MIN_LENGTH + 1);

        try {
            new ClientName($stringToShort);
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientNameInvalidExceptionClassName, $e);
        }

        try {
            new ClientName($stringToLong);
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientNameInvalidExceptionClassName, $e);
        }

        new ClientName($stringJustRight);
    }
}
