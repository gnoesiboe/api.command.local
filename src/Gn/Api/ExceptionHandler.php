<?php

namespace Gn\Api;

use Gn\Api\Response\Json\JSendErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\FlattenException;

/**
 * @inheritdoc
 */
class ExceptionHandler extends \Symfony\Component\Debug\ExceptionHandler
{

    /**
     * @var bool
     */
    protected $debug = null;

    /**
     * @param bool $debug
     * @param string $charset
     */
    public function __construct($debug = true, $charset = 'UTF-8')
    {
        $this->debug = $debug;

        parent::__construct($debug, $charset);
    }

    /**
     * @param \Exception|FlattenException $exception
     * @return JSendErrorResponse|Response
     */
    public function createResponse($exception)
    {
        if (($exception instanceof FlattenException) === false) {
            $exception = FlattenException::create($exception);
        }

        $data = array();

        if ($this->debug === true) {
            $data['trace'] = $exception->getTrace();
        }

        return new JSendErrorResponse(500, 'Server error', $data);
    }
}
