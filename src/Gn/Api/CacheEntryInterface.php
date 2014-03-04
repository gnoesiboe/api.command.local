<?php

namespace Gn\Api;

/**
 * CacheEntryInterface
 */
interface CacheEntryInterface
{

    /**
     * Sets the cached value
     *
     * @param mixed $value
     * @return $this
     */
    public function setValue($value);

    /**
     * Sets the cache lifetime in seconds
     *
     * @param int $lifetime
     * @return $this
     */
    public function setLifetime($lifetime);

    /**
     * Returns the Cache lifetime in seconds
     *
     * @return int
     */
    public function getLifetime();

    /**
     * Returns the DateTime that this cache entry is
     * to be invalidated
     *
     * @return \DateTime
     */
    public function getInvalidationDatetime();

    /**
     * Checks wether or not the cache entry is still valid and has
     * not expired yet.
     *
     * @return bool
     */
    public function isValid();

    /**
     * Returns the Cache value
     *
     * @return mixed
     */
    public function getValue();
}
