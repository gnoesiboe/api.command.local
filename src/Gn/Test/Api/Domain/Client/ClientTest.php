<?php

namespace Gn\Test\Api\Domain\Client;

use Gn\Api\Domain\Client\Client;
use Gn\Api\Domain\Client\ClientIdentifier;
use Gn\Api\Domain\Client\ClientKey;
use Gn\Api\Domain\Client\ClientName;
use Gn\Api\Domain\Permission\Permission;
use Gn\Api\Domain\Permission\PermissionIdentifier;
use Gn\Test;

/**
 * Client
 */
class ClientTest extends Test
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var ClientName
     */
    protected $clientName;

    /**
     * @var ClientIdentifier
     */
    protected $clientIdentifier;

    /**
     * @var ClientKey
     */
    protected $clientKey;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->clientName = new ClientName('Some client');
        $this->clientIdentifier = new ClientIdentifier('some-client');
        $this->clientKey = new ClientKey(sha1('somevalue'));

        $this->client = new Client($this->clientName, $this->clientIdentifier, $this->clientKey);
    }

    /**
     * Client::getKey should return a concrete implementation of ClientKeyInterface
     */
    public function testGetKeyReturnsAnImplementationOfClientKeyInterface()
    {
        $this->assertInstanceOf('\Gn\Api\Domain\Client\ClientKeyInterface', $this->client->getKey());
    }

    /**
     * The Client::hasPermission method should return true if the asked permission was
     * previously added to the client
     */
    public function testClientHasPermissionAfterItHasBeenAdded()
    {
        $permissionIdentifier = new PermissionIdentifier('some_permission');

        $this->client->addPermission(new Permission($permissionIdentifier));
        $this->assertTrue($this->client->hasPermission($permissionIdentifier));
    }

    /**
     * The Client::hasPermission method should turn fase if the client does not
     * have that permission.
     */
    public function testClientHasPermissionReturnsFalseWhenNoPermissionsAdded()
    {
        $permissionIdentifier = new PermissionIdentifier('some_permission');

        $this->assertFalse($this->client->hasPermission($permissionIdentifier));
    }

    /**
     * The Client::getKey should return the same value as was added via de constructor
     */
    public function testClientGetKeyReturnsTheKeyThatWasAddedWhenTheObjectWasMade()
    {
        $this->assertTrue($this->client->getKey()->getValue() === $this->clientKey->getValue());
    }

    /**
     * The Client::getKey method should return a concrete implementation of the ClientKeyInterface
     */
    public function testClientGetKeyReturnsAnImplementationOfClientKeyInterface()
    {
        $this->assertInstanceOf('\Gn\Api\Domain\Client\ClientKeyInterface', $this->client->getKey());
    }
}
