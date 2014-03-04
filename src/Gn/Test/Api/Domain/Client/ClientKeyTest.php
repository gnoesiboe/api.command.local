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
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientKeyInvalidExceptionClassName, $e);
        }

        try {
            new ClientKey($someFloat);
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientKeyInvalidExceptionClassName, $e);
        }

        try {
            new ClientKey($someObject);
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->clientKeyInvalidExceptionClassName, $e);
        }

        try {
            new ClientKey($someBool);
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
        $stringToShort = 'a9382';
        $stringToLong = 'asdfjaskjasdfjaskjasdfjaskjasdfjaskjasdfjaskjasdfjaskjasdfjaskjasdfjaskjasdfjaskjasdfjaskjasdfjaskjasdfjaskjasdfjaskjasdfjaskjasdfjaskj';
        $stringJustRight = sha1('32as#e');

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
