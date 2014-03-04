<?php

namespace Gn\Api;

/**
 * Token
 */
abstract class Token implements TokenInterface
{

    /**
     * @var mixed
     */
    protected $subject = null;

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
