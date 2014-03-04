<?php

namespace App\Domain\Category;

use Gn\Api\Domain\Title;

/**
 * CategoryTitle
 */
class CategoryTitle extends Title
{

    /**
     * @param string $value
     * @throws InvalidCategoryTitleException
     */
    protected function validateValue($value)
    {
        if (is_string($value) === false) {
            throw new InvalidCategoryTitleException('Category title should be of type String');
        }
    }
}
