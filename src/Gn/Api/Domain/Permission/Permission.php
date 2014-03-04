<?php

namespace Gn\Api\Domain\Permission;

/**
 * Permission
 */
class Permission implements PermissionInterface
{

    /**
     * @var int
     */
    protected $id;

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
     * @param PermissionIdentifier $identifier
     */
    public function __construct(PermissionIdentifier $identifier)
    {
        $this->identifier = $identifier->getValue();
    }

    /**
     * @return PermissionIdentifier
     */
    public function getIdentifier()
    {
        return new PermissionIdentifier($this->identifier);
    }
}
