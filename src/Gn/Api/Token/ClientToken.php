<?php

namespace Gn\Api\Token;

use Gn\Api\Domain\Client\ClientInterface;
use Gn\Api\Token;

/**
 * ClientToken
 *
 * @method ClientInterface getSubject
 */
class ClientToken extends Token
{

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->subject = $client;
    }
}
