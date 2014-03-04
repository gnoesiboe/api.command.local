<?php

namespace Gn\Api;

use Gn\Api\Domain\Client\ClientKey;
use Gn\Api\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request AS BaseRequest;

/**
 * Request
 */
class Request extends BaseRequest
{

    /**
     * @var string
     */
    const METHOD_POST = 'POST';

    /**
     * @var string
     */
    const METHOD_GET = 'GET';

    /**
     * @var string
     */
    const METHOD_PUT = 'PUT';

    /**
     * @var string
     */
    const METHOD_OPTIONS = 'OPTIONS';

    /**
     * @var string
     */
    const METHOD_DELETE = 'DELETE';

    /**
     * @return bool
     */
    public function hasIfModifiedSince()
    {
        return $this->headers->has('If-Modified-Since');
    }

    /**
     * @return \DateTime
     */
    public function getIfModifiedSince()
    {
        if ($this->hasIfModifiedSince() === false) {
            return null;
        }

        return new \DateTime($this->headers->get('If-Modified-Since'));
    }

    /**
     * @return bool
     */
    public function isJSONPRequest()
    {
        return $this->query->has('callback') === true;
    }

    /**
     * @return string
     */
    public function getJSONPCallback()
    {
        return $this->isJSONPRequest() === false ? null : $this->query->get('callback');
    }
}
