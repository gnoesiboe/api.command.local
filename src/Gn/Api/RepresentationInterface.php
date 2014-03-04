<?php

namespace Gn\Api;

/**
 * RepresentationInterface
 */
interface RepresentationInterface
{

    /**
     * @return array
     */
    public function getData();

    /**
     * @return array
     */
    public function getDebug();

    /**
     * @param array $debug
     * @return RepresentationInterface
     */
    public function setDebug(array $debug);
}
