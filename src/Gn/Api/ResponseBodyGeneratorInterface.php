<?php

namespace Gn\Api;

/**
 * ResponseBodyGeneratorInterface
 */
interface ResponseBodyGeneratorInterface
{

    /**
     * @param string $identifier
     * @param ResponseBodyGeneratorAdapterInterface $adapter
     *
     * @return ResponseBodyGeneratorInterface
     */
    public function registerAdapter($identifier, ResponseBodyGeneratorAdapterInterface $adapter);

    /**
     * @param string $identifier
     * @return ResponseBodyGeneratorInterface
     */
    public function setDefaultAdapterIdentifier($identifier);

    /**
     * @param Request $request
     * @return ResponseBodyGeneratorAdapterInterface
     */
    public function defineAdapter(Request $request);
}
