<?php

namespace Gn\Api;

use Gn\Api\Response\Json\JSendResponse;

/**
 * AppInterface
 */
interface RequestHandlerInterface
{

    /**
     * @return JSendResponse
     */
    public function execute();
}
