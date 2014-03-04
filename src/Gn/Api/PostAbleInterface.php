<?php

namespace Gn\Api;

use Gn\Api\Response\Json\JSendResponse;

/**
 * PostAbleInterface
 */
interface PostAbleInterface
{

    /**
     * @param Request $request
     * @param array $params
     *
     * @return JSendResponse
     */
    public function handlePost(Request $request, array $params);
}
