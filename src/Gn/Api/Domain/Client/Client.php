<?php

namespace Gn\Api\Domain\Client;

use Doctrine\Common\Collections\ArrayCollection;
use Gn\Api\Domain\Permission\PermissionIdentifier;
use Gn\Api\Domain\Permission\PermissionInterface;


/**
 * Client
 */
class Client implements ClientInterface
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var ArrayCollection
     */
    protected $permissions;

    /**
     * @param ClientName $name
     * @param ClientIdentifier $identifier
     * @param ClientKeyInterface $key
     */
    public function __construct(ClientName $name, ClientIdentifier $identifier, ClientKeyInterface $key)
    {
        $this->name = $name->getValue();
        $this->identifier = $identifier->getValue();
        $this->key = $key->getValue();

        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();

        $this->permissions = new ArrayCollection();
    }

    /**
     * @param PermissionIdentifier $permissionIdentifier
     * @return bool
     */
    public function hasPermission(PermissionIdentifier $permissionIdentifier)
    {
        foreach ($this->permissions as $permission) {
            /** @var PermissionInterface $permission */

            if ($permission->getIdentifier()->is($permissionIdentifier) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return ClientKeyInterface
     */
    public function getKey()
    {
        return new ClientKey($this->key);
    }
}
