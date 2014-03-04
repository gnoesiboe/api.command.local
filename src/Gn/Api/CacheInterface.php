<?php

namespace Gn\Api;

/**
 * Cache class
 */
interface CacheInterface
{

    /**
     * Get the cache entry with the supplied key
     *
     * @param string $key
     * @param mixed $default            Value to return when no cache key was found
     * @param bool $validateIsValid
     *
     * @return CacheEntryInterface
     */
    public function get($key, $default = null, $validateIsValid = true);

    /**
     * Set a new cache entry on a specific key
     *
     * @param string $key
     * @param CacheEntryInterface $entry
     *
     * @return $this
     */
    public function set($key, CacheEntryInterface $entry);

    /**
     * Check if the Cache holds a specific key
     *
     * @param string $key
     * @return bool
     */
    public function has($key);

    /**
     * Deletes a specific key from the cache
     *
     * @param string $key
     * @return bool
     */
    public function delete($key);
}
