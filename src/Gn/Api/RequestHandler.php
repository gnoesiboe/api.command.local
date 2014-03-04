<?php

namespace Gn\Api;

use Gn\Api\Exception\UnauthorizedException;
use Gn\Api\Exception\BadRequestException;
use Gn\Api\Response\Json\JSendResponse;
use Gn\Api\Response\Json\JSendSuccessResponse;
use Gn\Api\Response\JsonResponse;
use Gn\Api\ServiceLocator\RequestHandlerServiceLocator;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * App
 */
class RequestHandler implements RequestHandlerInterface
{

    /**
     * @var RequestHandlerServiceLocator
     */
    protected $serviceLocator = null;

    /**
     * @param RequestHandlerServiceLocator $serviceLocator
     */
    public function __construct(RequestHandlerServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        $this->configure();
    }

    /**
     * Configures this app
     */
    public function configure()
    {
        $this->configureErrorHandling();
    }

    /**
     * Configures this App's error reporting/handling
     *
     * @todo setup correctly
     */
    protected function configureErrorHandling()
    {
        /*error_reporting(-1);

        ErrorHandler::register($this->environment->isProductionEnvironment() === false ? E_ALL : -1);

        if ('cli' !== php_sapi_name()) {
            ExceptionHandler::register();
        }
        elseif (!ini_get('log_errors') || ini_get('error_log')) {
            ini_set('display_errors', $this->environment->isProductionEnvironment() === false ? 1 : 0);
        }*/
    }

    /**
     * Creates an instance (fluent interface)
     *
     * @param RequestHandlerServiceLocator $serviceLocator
     * @return RequestHandler
     */
    public static function create(RequestHandlerServiceLocator $serviceLocator)
    {
        return new static($serviceLocator);
    }

    /**
     * @return JSendResponse
     * @throws \Exception
     */
    public function execute()
    {
        $request = $this->serviceLocator->getRequest();

        try {
            $response = $this->executeRequest($request);
        }
        catch (ResourceNotFoundException $e) {
            $response = $this->serviceLocator->getResponseFactory()->generateNotFoundResponse($e);
        }
        catch (MethodNotAllowedException $e) {
            $response = $this->serviceLocator->getResponseFactory()->generateMethodNotAllowdResponse();
        }
        catch (BadRequestException $e) {
            $response = $this->serviceLocator->getResponseFactory()->generateBadRequestResponse($e);
        }
        catch (UnauthorizedException $e) {
            $response = $this->serviceLocator->getResponseFactory()->generateUauthorizedResponse($e);
        }
        catch (\Exception $e) {
            $response = $this->serviceLocator->getResponseFactory()->generateServerErrorResponse($e);
        }

        if ($request->isJSONPRequest() === true) {
            $response->setJSONPCallback($request->getJSONPCallback());
        }

        return $response;
    }

    /**
     * @param Request $request
     * @return JSendResponse
     *
     * @throws \UnexpectedValueException
     * @throws \Exception
     */
    protected function executeRequest(Request $request)
    {
        /** @var Router $router */
        $router = $this->serviceLocator->getRouter();

        $routeParameters = $router->match($request);

        /** @var Route $currentRoute */
        $currentRoute = $this->serviceLocator->getRouteCollection()->get($routeParameters['_route']);
        $this->validateRoute($currentRoute);

        $firewall = $this->serviceLocator->getFirewall();
        if ($request->isMethod('OPTIONS') === false) {
            $firewall->validate($currentRoute, $request);
        }

        $controller = $this->serviceLocator->getControllerFactory()->createController($currentRoute->getControllerClassName());

        $requestMethod = $request->getMethod();
        switch ($requestMethod)
        {
            case Request::METHOD_OPTIONS:
                $response = $this->handleOptions($currentRoute, $firewall);
                break;

            case Request::METHOD_GET:
                $response = $this->handleGet($controller, $request, $routeParameters);
                break;

            case Request::METHOD_POST:
                throw new \Exception('@todo'); //@todo
                // $response = $this->handlePost($controller, $request, $routeParameters);
                break;
            
            case Request::METHOD_PUT:
                throw new \Exception('@todo'); //@todo

            default:
                throw new \UnexpectedValueException(sprintf('Method: \'%s\' not supported', $requestMethod));
        }

        return $response;
    }

    /**
     * @param string $route
     * @throws \UnexpectedValueException
     */
    protected function validateRoute($route)
    {
        if (($route instanceof Route) === false) {
            throw new \UnexpectedValueException('Route should be an instance of Gn\Api\Route');
        }
    }

    /**
     * Wether or not to display debug information for this request
     *
     * @return bool
     */
    protected function doDisplayDebugInfo()
    {
        return $this->serviceLocator->getEnvironment()->isDevelopmentEnvironment() === true;
    }

    /**
     * @param ControllerInterface $controller
     * @param Request $request
     * @param array $params
     *
     * @return JSendResponse
     *
     * @throws \UnexpectedValueException
     */
    protected function handlePost(ControllerInterface $controller, Request $request, array $params)
    {
        if (($controller instanceof PostAbleInterface) === false) {
            throw new \UnexpectedValueException('Get controller should implement PostAbleInterface');
        }

        /** @var PostAbleInterface $controller */

        return $controller->handlePost($request, $params);
    }

    /**
     * @param ControllerInterface $controller
     * @param Request $request
     * @param array $params
     *
     * @return JSendResponse
     *
     * @throws \UnexpectedValueException
     */
    protected function handleGet(ControllerInterface $controller, Request $request, array $params)
    {
        if (($controller instanceof GetAbleInterface) === false) {
            throw new \UnexpectedValueException('Controller used for GET requests should implement GetAbleInterface');
        }

        /** @var ControllerInterface|GetAbleInterface $controller */

        $representation = $controller->handleGet($request, $params);

        if (($representation instanceof RepresentationInterface) === false) {
            throw new \UnexpectedValueException('Representation should implement Gn\Api\RepresentationInterface');
        }

        if ($this->doDisplayDebugInfo() === true) {
            $representation->setDebug(array(
                'sql_queries' => $this->serviceLocator->getDoctrineSqlLogger()->getEntriesAsArray(),
                'memory_usage' => memory_get_usage(true)
            ));
        }

        $responseBodyGeneratorAdapter = $this->serviceLocator->getResponseBodyGenerator()->defineAdapter($request);

        return new Response(
            $responseBodyGeneratorAdapter->fromRepresentation($representation),
            Response::HTTP_OK,
            array(
                'Content-Type' => $responseBodyGeneratorAdapter->getContentType()
            )
        );

        // @todo how to get the last modified value of the response at this point? Via the representation seems to be a workaround
        /*
        if ($request->hasIfModifiedSince() === true && $request->getIfModifiedSince() > $response->getLastModified()) {
            $response = $this->serviceLocator->getResponseFactory()->generateNotModifiedResponse();
        }

        return $response;
        */
    }

    /**
     * @see http://zacstewart.com/2012/04/14/http-options-method.html
     * @see https://github.com/technoweenie/sawyer/blob/master/example/user.schema.json
     *
     *   or ..
     *
     * http://ludovicurbain.blogspot.be/2013/06/rest-explained.html
     * https://github.com/SPORE/specifications/blob/master/spore_description.pod
     *
     * @param Route $route
     * @param FirewallInterface $firewall
     *
     * @return Response
     */
    protected function handleOptions(Route $route, FirewallInterface $firewall)
    {
        $response = new Response('', 200);

        // locate the required headers and allow only those
        $requiredHeaders = array();
        foreach ($route->getFirewallAdapterKeys() as $firewallAdapterKey) {
            foreach ($firewall->getAdapter($firewallAdapterKey)->getRequiredHeaders() as $header) {
                $requiredHeaders[$header] = $header;
            }
        }

        $methodString = implode(', ', $route->getMethods());

        $response->headers->add(array(
            'Allow'                         => $methodString,
            'Access-Control-Allow-Methods'  => $methodString,
            'Access-Control-Allow-Headers'  => implode(', ', array_values($requiredHeaders)),
            'Access-Control-Allow-Origin'   => '*'
        ));

        //@todo return allowed content types

        return $response;
    }
}
