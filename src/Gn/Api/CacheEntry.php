<?php

namespace Gn\Api;

/**
 * CacheEntry
 */
class CacheEntry implements CacheEntryInterface
{

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var int
     */
    protected $lifetime;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @param mixed $value          Value to be cached
     * @param int $lifetime         Cache lifetime in seconds
     */
    public function __construct($value, $lifetime = 3600)
    {
        $this->setValue($value);
        $this->setLifetime($lifetime);

        $this->createdAt = new \DateTime();
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param int $lifetime
     * @return $this
     */
    public function setLifetime($lifetime)
    {
        $this->validateLifetime($lifetime);
        $this->lifetime = $lifetime;

        return $this;
    }

    /**
     * @param int $lifetime
     * @throws \UnexpectedValueException
     */
    protected function validateLifetime($lifetime)
    {
        if (is_int($lifetime) === false) {
            throw new \UnexpectedValueException('Cache lifetime should be of type int');
        }
    }

    /**
     * @return \DateTime
     */
    public function getInvalidationDatetime()
    {
        $invalidationDatetime = clone $this->createdAt;
        $invalidationDatetime->modify('+ ' . (int) $this->getLifetime() . ' seconds');

        return $invalidationDatetime;
    }

    /**
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        $now = new \DateTime();

        return $now < $this->getInvalidationDatetime();
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
