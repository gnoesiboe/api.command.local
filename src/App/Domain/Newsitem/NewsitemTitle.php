<?php

namespace App\Domain\Newsitem;

use Gn\Api\Domain\Title;

/**
 * NewsitemTitle
 */
class NewsitemTitle extends Title
{

    /**
     * @param string $value
     * @throws InvalidNewsitemTitleException
     */
    protected function validateValue($value)
    {
        if (is_string($value) === false) {
            throw new InvalidNewsitemTitleException('Newsitem title should be of type String');
        }
    }
}
