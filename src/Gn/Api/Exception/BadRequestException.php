<?php

namespace Gn\Api\Exception;

/**
 * BadRequestException
 */
class BadRequestException extends \Exception
{

    /**
     * @var array
     */
    protected $children = array();

    /**
     * @param \Exception[] $exceptions
     */
    public function setChildren(array $exceptions)
    {
        $this->resetChildErrors();

        foreach ($exceptions as $exception) {
            /** @var \Exception $exception */

            $this->addChild($exception);
        }
    }

    /**
     * @return \Exception[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        return count($this->children) > 0;
    }

    /**
     * @param \Exception $e
     */
    public function addChild(\Exception $e)
    {
        $this->children[] = $e;
    }

    /**
     * Resets the child errors stack
     */
    protected function resetChildErrors()
    {
        $this->children = array();
    }
}
