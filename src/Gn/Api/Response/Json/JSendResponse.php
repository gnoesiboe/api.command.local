<?php

namespace Gn\Api\Response\Json;

use Gn\Api\Response\JsonResponse;

/**
 * Response class
 */
class JSendResponse extends JsonResponse
{

    /**
     * @var string
     */
    const STATUS_SUCCESS = 'success';

    /**
     * @var string
     */
    const STATUS_FAIL = 'fail';

    /**
     * @var string
     */
    const STATUS_ERROR = 'error';

    /**
     * @var string
     */
    const MESSAGE_UNAUTHORIZED = 'UNAUTHORIZED';

    /**
     * @var string
     */
    const MESSAGE_BAD_REQUEST = 'BAD_REQUEST';

    /**
     * @var string
     */
    const MESSAGE_METHOD_NOT_ALLOWED = 'METHOD_NOT_ALLOWED';

    /**
     * @var string
     */
    const MESSAGE_RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND';

    /**
     * @var string
     */
    const MESSAGE_SERVER_ERROR = 'SERVER_ERROR';

    /**
     * @var array
     */
    protected static $supportedMessages = array(
        self::MESSAGE_UNAUTHORIZED,
        self::MESSAGE_BAD_REQUEST,
        self::MESSAGE_METHOD_NOT_ALLOWED,
        self::MESSAGE_RESOURCE_NOT_FOUND,
        self::MESSAGE_SERVER_ERROR
    );

    /**
     * @var array
     */
    protected static $supportedStatuses = array(
        self::STATUS_SUCCESS, // All went well, and (usually) some data was returned.
        self::STATUS_FAIL, // There was a problem with the data submitted, or some pre-condition of the API call wasn't satisfied
        self::STATUS_ERROR // An error occurred in processing the request, i.e. an exception was thrown
    );

    /**
     * @param int $httpStatusCode
     * @param string $status
     * @param array|null $data
     * @param string $message
     * @param int $code
     */
    public function __construct($httpStatusCode, $status, array $data = null, $message = null, $code = null)
    {
        self::validateStatus($status);
        self::validateHttpStatusCode($httpStatusCode);
        self::validateMessage($message);
        self::validateCode($code);

        $data = array(
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'code' => $code,
        );

        $data = $this->prepareData($data);
        $this->validateDataForStatusMessageRequiredKeys($data, $status);

        parent::__construct($data, $httpStatusCode);
    }

    /**
     * @param int $code
     * @throws \UnexpectedValueException
     */
    protected static function validateCode($code)
    {
        if (is_null($code) === true) {
            return;
        }

        if (is_int($code) === false) {
            throw new \UnexpectedValueException('Code should be of type int');
        }
    }

    /**
     * @param string $message
     * @throws \UnexpectedValueException
     */
    protected static function validateMessage($message)
    {
        if (is_null($message) === true) {
            return;
        }

        if (is_string($message) === false) {
            throw new \UnexpectedValueException('Message should be of type string');
        }

        if (in_array($message, self::$supportedMessages) === false) {
            throw new \UnexpectedValueException('Message should be one of: ' . implode(', ', self::$supportedMessages));
        }
    }

    /**
     * @param array $data
     * @return array
     */
    protected function prepareData(array $data)
    {
        // remove empty values from array
        return array_filter($data);
    }

    /**
     * @param array $data
     * @param string $message
     *
     * @throws \UnexpectedValueException
     *
     * @see http://labs.omniti.com/labs/jsend
     */
    protected static function validateDataForStatusMessageRequiredKeys(array $data, $message)
    {
        switch ($message) {
            case self::STATUS_SUCCESS:
                $requiredKeys = array('status', 'data');

                break;

            case self::STATUS_FAIL:
                $requiredKeys = array('status', 'data');

                break;

            case self::STATUS_ERROR:
                $requiredKeys = array('status', 'message');

                break;

            default:
                throw new \UnexpectedValueException(sprintf('Message: %s not supported', $message));
        }

        foreach ($requiredKeys as $requiredKey) {
            /** @var string $requiredKey */

            if (array_key_exists($requiredKey, $data) === false) {
                throw new \UnexpectedValueException(sprintf('Missing required key: %s for status: %s', $requiredKey, $data['status']));
            }
        }
    }

    /**
     * @param string $httpStatusCode
     * @throws \UnexpectedValueException
     */
    protected static function validateHttpStatusCode($httpStatusCode)
    {
        if (is_string($httpStatusCode) === true) {
            throw new \UnexpectedValueException('Http status code should be of type int');
        }
    }

    /**
     * @param string $status
     * @throws \UnexpectedValueException
     */
    protected static function validateStatus($status)
    {
        if (is_string($status) === false) {
            throw new \UnexpectedValueException('Message should be of type string');
        }

        if (in_array($status, self::$supportedStatuses) === false) {
            throw new \UnexpectedValueException('Message identifier should be one of: ' . implode(', ', self::$supportedStatuses));
        }
    }
}
