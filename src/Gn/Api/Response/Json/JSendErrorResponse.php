<?php

namespace Gn\Api\Response\Json;

/**
 * ErrorResponse
 *
 * @author gnoesiboe <gnoesiboe@freshheads.com>
 */
class JSendErrorResponse extends JSendResponse
{

  /**
   * @param int $httpStatusCode
   * @param array|null $message
   * @param array $data
   */
  public function __construct($httpStatusCode, $message, array $data = array())
  {
    parent::__construct($httpStatusCode, JSendErrorResponse::STATUS_ERROR, $data, $message, null);
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
