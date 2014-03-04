<?php

namespace Gn\Api;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Response
 */
class Response extends \Symfony\Component\HttpFoundation\Response
{
    /**
     * @param string $content
     * @param int $status
     * @param array $headers
     */
    public function __construct($content = '', $status = self::HTTP_OK, $headers = array())
    {
        parent::__construct($content, $status, $headers);

        //@todo move somewhere else as this differs per route
        /*$this->headers->add(array(
            'Access-Control-Allow-Methods' => 'GET, OPTIONS, POST, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'client-key',
            'Access-Control-Allow-Origin' => 'http://www.command.local'
        ));*/
    }

    /**
     * @return bool
     */
    public function hasContent()
    {
        $content = $this->getContent();

        return is_string($content) === true && strlen($content) > 0;
    }
}
