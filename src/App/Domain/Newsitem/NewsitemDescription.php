<?php

namespace App\Domain\Newsitem;

use Gn\Api\Domain\Description;

/**
 * NewsitemDescription
 */
class NewsitemDescription extends Description
{

    /**
     * @param string $value
     * @throws InvalidNewsitemDescriptionException
     */
    protected function validateValue($value)
    {
        if (is_string($value) === false) {
            throw new InvalidNewsitemDescriptionException('Description should be of type String');
        }
    }
}
