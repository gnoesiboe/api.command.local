<?php

namespace Gn\Api;

use Gn\Api\Exception\BadRequestException;
use Gn\Api\Exception\UnauthorizedException;
use Gn\Api\Response\Json\JSendErrorResponse;
use Gn\Api\Response\Json\JSendFailResponse;
use Gn\Api\Response\Json\JSendResponse;
use Gn\Api\Response\JsonResponse;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * ResponseFactory
 */
class ResponseFactory
{

    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return Response
     */
    public function generateNotModifiedResponse()
    {
        return new Response('', JsonResponse::HTTP_NOT_MODIFIED);
    }

    /**
     * @param UnauthorizedException $e
     * @return JSendFailResponse
     */
    public function generateUauthorizedResponse(UnauthorizedException $e)
    {
        $data = array(
            'message' => $e->getMessage()
        );

        return new JSendFailResponse(JsonResponse::HTTP_UNAUTHORIZED, $data, JSendResponse::MESSAGE_UNAUTHORIZED);
    }

    /**
     * @param BadRequestException $e
     * @return JSendFailResponse
     */
    public function generateBadRequestResponse(BadRequestException $e)
    {
        $data = array (
            'message' => $e->getMessage()
        );

        if ($e->hasChildren() === true) {
            $data['detail'] = array();

            foreach ($e->getChildren() as $childException) {
                $data['detail'][] = $childException->getMessage();
            }
        }

        return new JSendFailResponse(JsonResponse::HTTP_BAD_REQUEST, $data, JSendResponse::MESSAGE_BAD_REQUEST);
    }

    /**
     * @param \Exception $e
     * @return JSendFailResponse
     */
    public function generateServerErrorResponse(\Exception $e)
    {
        $data = array();

        if ($this->environment->isProductionEnvironment() === false) {
            $data = array(
                'message' => $e->getMessage(),
                'stack' => $e->getTrace()
            );
        }

        return new JSendErrorResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, JSendResponse::MESSAGE_SERVER_ERROR, $data);
    }

    /**
     * @return JSendFailResponse
     */
    public function generateMethodNotAllowdResponse()
    {
        $data = array(
            'message' => 'The request method you used is not allowed for this route'
        );

        return new JSendFailResponse(JsonResponse::HTTP_METHOD_NOT_ALLOWED, $data, JSendResponse::MESSAGE_METHOD_NOT_ALLOWED);
    }

    /**
     * @param ResourceNotFoundException $e
     * @return JSendFailResponse
     */
    public function generateNotFoundResponse(ResourceNotFoundException $e)
    {
        $data = array(
            'meaning' => $e->getMessage()
        );

        return new JSendFailResponse(JsonResponse::HTTP_NOT_FOUND, $data, JSendResponse::MESSAGE_RESOURCE_NOT_FOUND);
    }
}
