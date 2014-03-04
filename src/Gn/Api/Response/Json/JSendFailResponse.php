<?php

namespace Gn\Api\Response\Json;

/**
 * JSendFailResponse
 */
class JSendFailResponse extends JSendResponse
{

    /**
     * @param int $httpStatusCode
     * @param array $data
     * @param null $message
     */
    public function __construct($httpStatusCode, array $data, $message = null)
    {
        parent::__construct($httpStatusCode, JSendErrorResponse::STATUS_FAIL, $data, $message, null);
    }

    /**
     * @param string $status
     * @throws \UnexpectedValueException
     */
    protected static function validateStatus($status)
    {
        parent::validateStatus($status);

        if ($status < 400 && $status >= 200) {
            throw new \UnexpectedValueException('Status should be an error http status code');
        }
    }
}
