<?php

namespace Gn\Test\Api\Domain\Client;

use Gn\Api\Domain\Client\ClientKey;
use Gn\Test;

/**
 * ClientKeyTest
 */
class ClientKeyTest extends Test
{

    /**
     * @var string
     */
    protected $clientKeyInvalidExceptionClassName = '\Gn\Api\Domain\Client\ClientKeyInvalidException';

    /**
     * Tests that the ClientKey only accepts string
     */
    public function testOnlyAcceptsStringValues()
    {
        $someInt = 3923;
        $someFloat = 22.4;
        $someObject = new \stdClass();
        $someBool = true;
        $someString = sha1('39230239323');

        try {
            new ClientKey($someInt);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientKeyInvalidExceptionClassName, $e);
        }

        try {
            new ClientKey($someFloat);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientKeyInvalidExceptionClassName, $e);
        }

        try {
            new ClientKey($someObject);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientKeyInvalidExceptionClassName, $e);
        }

        try {
            new ClientKey($someBool);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientKeyInvalidExceptionClassName, $e);
        }

        new ClientKey($someString);
    }

    /**
     * The value should be a string with 40 characters
     */
    public function testOnlyAcceptsAStringOf40Characters()
    {
        $stringToShort = str_repeat('x', ClientKey::SUPPORTED_LENGTH - 1);
        $stringToLong = str_repeat('x', ClientKey::SUPPORTED_LENGTH + 1);
        $stringJustRight = str_repeat('x', ClientKey::SUPPORTED_LENGTH);

        try {
            new ClientKey($stringToShort);
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientKeyInvalidExceptionClassName, $e);
        }

        try {
            new ClientKey($stringToLong);
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientKeyInvalidExceptionClassName, $e);
        }

        new ClientKey($stringJustRight);
    }

    /**
     * Client key should implement the ClientKeyInterface
     */
    public function testImplementsClientKeyInterface()
    {
        $validClientKeyValue = sha1('test');
        $clientKeyInstance = new ClientKey($validClientKeyValue);

        $this->assertInstanceOf('\Gn\Api\Domain\Client\ClientKeyInterface', $clientKeyInstance);
    }
}
