<?php

namespace Gn\Api;

/**
 * ResponseBodyGeneratorAdapter
 */
interface ResponseBodyGeneratorAdapterInterface
{

    /**
     * @param RepresentationInterface $representation
     * @return string
     */
    public function fromRepresentation(RepresentationInterface $representation);

    /**
     * @return string
     */
    public function getContentType();
}
