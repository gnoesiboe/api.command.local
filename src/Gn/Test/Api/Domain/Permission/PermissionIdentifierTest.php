<?php

namespace Gn\Test\Api\Domain\Permission;

use Gn\Api\Domain\Permission\PermissionIdentifier;
use Gn\Test;

/**
 * PermissionIdentifierTest
 */
class PermissionIdentifierTest extends Test
{

    /**
     * @var string
     */
    protected $permissionIdentifierInvalidExceptionClassName = '\Gn\Api\Domain\Permission\PermissionIdentifierInvalidException';

    /**
     * The value of a permission identifier is only allowed to be a string
     */
    public function testOnlyAcceptsAStringValue()
    {
        $someInt = 3923;
        $someFloat = 22.4;
        $someObject = new \stdClass();
        $someBool = true;
        $someString = str_repeat('x', PermissionIdentifier::MIN_LENGTH + 1);

        try {
            new PermissionIdentifier($someInt);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->permissionIdentifierInvalidExceptionClassName, $e);
        }

        try {
            new PermissionIdentifier($someFloat);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->permissionIdentifierInvalidExceptionClassName, $e);
        }

        try {
            new PermissionIdentifier($someObject);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->permissionIdentifierInvalidExceptionClassName, $e);
        }

        try {
            new PermissionIdentifier($someBool);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->permissionIdentifierInvalidExceptionClassName, $e);
        }

        // should not trigger exception
        new PermissionIdentifier($someString);
    }

    /**
     * Empty strings are not allowed as value
     */
    public function testEmptyStringsAreNotAllowed()
    {
        try {
            new PermissionIdentifier('');
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->permissionIdentifierInvalidExceptionClassName, $e);
        }
    }

    /**
     * Only lower case letters and underscores are allowed as value
     */
    public function testOnlyLowerCaseLettersAndUnderscoresAreAllowedAsValue()
    {
        $firstTestValue = 'test_1';
        $secondTestValue = 'TesT';
        $thirdTestValue = '3-Q\;';
        $fourthTestValue = 'Test_With_CAPITALS';
        $validTestValue = 'some_identifier';

        try {
            new PermissionIdentifier($firstTestValue);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->permissionIdentifierInvalidExceptionClassName, $e);
        }

        try {
            new PermissionIdentifier($secondTestValue);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->permissionIdentifierInvalidExceptionClassName, $e);
        }

        try {
            new PermissionIdentifier($thirdTestValue);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->permissionIdentifierInvalidExceptionClassName, $e);
        }

        try {
            new PermissionIdentifier($fourthTestValue);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->permissionIdentifierInvalidExceptionClassName, $e);
        }

        // should not trigger exception
        new PermissionIdentifier($validTestValue);
    }

    /**
     * Value should have a minimum length of ten characters. If not the invalid exception should be triggered
     */
    public function testValueShouldHaveAMinimumLengthOfTenCharacters()
    {
        $value = str_repeat('x', PermissionIdentifier::MIN_LENGTH - 1);

        try {
            new PermissionIdentifier($value);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->permissionIdentifierInvalidExceptionClassName, $e);
        }
    }

    /**
     * value should have a max length of fifty characters. If not, the invalid exception should be thrown.
     */
    public function testValueShouldHaveAMaximumLengthOfFiftyCharacters()
    {
        $value = str_repeat('x', PermissionIdentifier::MAX_LENGTH + 1);

        try {
            new PermissionIdentifier($value);
            $this->assertTrue(false, 'Code should not get to this point as the error should be triggered');
        } catch (\Exception $e) {
            $this->assertInstanceOf($this->permissionIdentifierInvalidExceptionClassName, $e);
        }
    }
}
