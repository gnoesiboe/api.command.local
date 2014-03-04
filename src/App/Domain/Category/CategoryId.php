<?php

namespace App\Domain\Category;

use Gn\Api\Domain\Id;
use App\Domain\Newsitem\InvalidNewsitemIdException;

/**
 * CategoryId
 */
class CategoryId extends Id
{

    /**
     * @param int $value
     * @throws
     */
    protected function throwInvalidValueException($value)
    {
        throw new InvalidNewsitemIdException('Category id should be of type int');
    }
}
