<?php

namespace Gn\Api\Response\Json;

use Gn\Api\RepresentationInterface;

/**
 * JSendSuccessResponse
 *
 * @author gnoesiboe <gnoesiboe@freshheads.com>
 */
class JSendSuccessResponse extends JSendResponse
{

    /**
     * @param int $httpStatusCode
     * @param array $content
     */
    public function __construct($httpStatusCode, $content)
    {
        parent::__construct($httpStatusCode, self::STATUS_SUCCESS, $content, null, null);
    }

    /**
     * @param int $httpStatusCode
     * @throws \UnexpectedValueException
     */
    protected static function validateHttpStatusCode($httpStatusCode)
    {
        parent::validateHttpStatusCode($httpStatusCode);

        if ($httpStatusCode >= 400) {
            throw new \UnexpectedValueException('Status code should be a sucess status code');
        }
    }
}
