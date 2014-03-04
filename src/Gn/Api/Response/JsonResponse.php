<?php

namespace Gn\Api\Response;

use Gn\Api\Response;

/**
 * Response
 */
class JsonResponse extends Response
{

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $JSONPcallback = null;

    /**
     * Constructor.
     *
     * @param array   $data    The response data
     * @param integer $status  The response status code
     * @param array   $headers An array of response headers
     */
    public function __construct(array $data = array(), $status = 200, $headers = array())
    {
        parent::__construct('', $status, $headers);

        $this->setData($data);
    }

    /**
     * {@inheritDoc}
     */
    public static function create($data = null, $status = 200, $headers = array())
    {
        return new static($data, $status, $headers);
    }

    /**
     * Sets the data to be sent as json.
     *
     * @param mixed $data
     * @return JsonResponse
     */
    public function setData($data = array())
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function appendData(array $data)
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \InvalidArgumentException
     */
    public function send()
    {
        // Encode <, >, ', &, and " for RFC4627-compliant JSON, which may also be embedded into HTML.
        $this->content = json_encode($this->getData(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException($this->transformJsonError());
        }

        if ($this->hasJSONPCallback() === true) {

            // Not using application/javascript for compatibility reasons with older browsers.
            $this->headers->set('Content-Type', 'text/javascript');

            $this->setContent(sprintf('%s(%s);', $this->JSONPcallback, $this->content));
        } elseif ($this->headers->has('Content-Type') === false) {
            $this->headers->set('Content-Type', 'application/json');
        }

        return parent::send();
    }

    /**
     * @return bool
     */
    public function hasJSONPCallback()
    {
        return is_string($this->JSONPcallback) === true;
    }

    /**
     * Sets the JSONP callback.
     *
     * @param string|null $callback The JSONP callback or null to use none
     *
     * @return JsonResponse
     *
     * @throws \InvalidArgumentException When the callback name is not valid
     */
    public function setJSONPCallback($callback = null)
    {
        if (null !== $callback) {
            // taken from http://www.geekality.net/2011/08/03/valid-javascript-identifier/
            $pattern = '/^[$_\p{L}][$_\p{L}\p{Mn}\p{Mc}\p{Nd}\p{Pc}\x{200C}\x{200D}]*+$/u';
            $parts = explode('.', $callback);
            foreach ($parts as $part) {
                if (!preg_match($pattern, $part)) {
                    throw new \InvalidArgumentException('The callback name is not valid.');
                }
            }
        }

        $this->JSONPcallback = $callback;
    }

    /**
     * @return string
     */
    private function transformJsonError()
    {
        if (function_exists('json_last_error_msg')) {
            return json_last_error_msg();
        }

        switch (json_last_error()) {
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded.';

            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch.';

            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found.';

            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON.';

            case JSON_ERROR_UTF8:
                return 'Malformed UTF-8 characters, possibly incorrectly encoded.';

            default:
                return 'Unknown error.';
        }
    }
}
