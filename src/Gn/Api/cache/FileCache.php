<?php

namespace Gn\Api\Cache;

use Gn\Api\CacheEntryInterface;
use Gn\Api\CacheInterface;
use Gn\Api\Directory;


/**
 * ResultCache
 */
class FileCache implements CacheInterface
{

    /**
     * @var Directory
     */
    protected $directory;

    /**
     * @param Directory $directory
     */
    public function __construct(Directory $directory)
    {
        $this->directory = $directory;
    }

    /**
     * Get the cache entry with the supplied key
     *
     * @param string $key               The key the cached value is stored to
     * @param mixed $default            Value to return when no cache key was found
     * @param bool $validateIsValid     If true, the entry is only returned it has not expired
     *
     * @return CacheEntryInterface|mixed
     * @return CacheEntryInterface|mixed
     */
    public function get($key, $default = null, $validateIsValid = true)
    {
        $this->validateKey($key);
        $filePath = $this->generateFilePath($key);

        if ($this->checkFileExistsOnServer($filePath) === false) {
            return $default;
        }

        $entry = $this->retrieveFileFromServer($filePath);

        if (($entry instanceof CacheEntryInterface) === false) {
            return $default;
        }

        if ($validateIsValid === true && $entry->isValid() === false) {
            $this->deleteFileOnServer($filePath);

            return $default;
        }

        return $entry;
    }

    /**
     * @param string $filePath
     */
    protected function deleteFileOnServer($filePath)
    {
        unlink($filePath);
    }

    /**
     * @param string $filePath
     * @return CacheEntryInterface
     */
    protected function retrieveFileFromServer($filePath)
    {
        $contents = file_get_contents($filePath);

        return unserialize($contents);
    }

    /**
     * Set a new cache entry on a specific key
     *
     * @param string $key
     * @param CacheEntryInterface $entry
     *
     * @return $this
     */
    public function set($key, CacheEntryInterface $entry)
    {
        $this->validateKey($key);

        $this->writeFileToServer(
            $this->generateFilePath($key),
            $this->prepareValue($entry)
        );
    }

    /**
     * @param string $key
     * @throws \UnexpectedValueException
     */
    protected function validateKey($key)
    {
        if (is_string($key) === false) {
            throw new \UnexpectedValueException('Key should be of type string');
        }

        $nonAllowedCharacters = "\\/?%*:|\"<>";

        if (strpbrk($key, "\\/?%*:|\"<>") === true) {
            throw new \UnexpectedValueException('Key may not contain any of the following characters: ', $nonAllowedCharacters);
        }
    }

    /**
     * @param string $key
     * @return string
     */
    protected function generateFilePath($key)
    {
        return $this->directory->getValue() . DIRECTORY_SEPARATOR . $key . '.cache';
    }

    /**
     * @param string $filePath
     * @param string $value
     */
    protected function writeFileToServer($filePath, $value)
    {
        $handle = fopen($filePath, 'w');

        fwrite($handle, $value);
        fclose($handle);
    }

    /**
     * @param mixed $value
     * @return string
     */
    protected function prepareValue($value)
    {
        return serialize($value);
    }

    /**
     * Check if the Cache holds a specific key
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        $nonExistentValue = null;
        $value = $this->getValue($key, $nonExistentValue);

        return $value === $nonExistentValue;
    }

    /**
     * @param string $filePath
     * @return bool
     */
    protected function checkFileExistsOnServer($filePath)
    {
        return file_exists($filePath) === true;
    }

    /**
     * Deletes a specific key from the cache
     *
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        $this->validateKey($key);

        $filePath = $this->generateFilePath($key);

        if ($this->checkFileExistsOnServer($filePath) === true) {
            $this->deleteFileOnServer($filePath);

            return true;
        }

        return false;
    }
}
