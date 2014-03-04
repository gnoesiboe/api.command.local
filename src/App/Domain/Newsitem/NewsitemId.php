<?php

namespace App\Domain\Newsitem;

use Gn\Api\Domain\Id;

/**
 * NewsitemId
 */
class NewsitemId extends Id
{

    /**
     * @param mixed $value
     * @throws InvalidNewsitemIdException
     */
    protected function throwInvalidValueException($value)
    {
        throw new InvalidNewsitemIdException('Newsitem id should be of type int');
    }
}
