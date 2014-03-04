<?php

namespace Gn\Api;

/**
 * GetAbleInterface
 */
interface GetAbleInterface
{

    /**
     * @param Request $request
     * @param array $params
     *
     * @return RepresentationInterface
     */
    public function handleGet(Request $request, array $params);
}
