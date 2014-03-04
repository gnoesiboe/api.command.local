<?php

namespace App\Controller\Newsitem;

use App\Controller\Newsitem;
use App\Representation;
use App\RepresentationFactory;
use Gn\Api\Cache\FileCache;
use Gn\Api\CacheEntry;
use Gn\Api\GetAbleInterface;
use Gn\Api\Request;

use Gn\Api\Response\Json\JSendResponse;
use Gn\Api\Response\Json\JSendSuccessResponse;

/**
 * Index
 */
class IndexController extends Newsitem implements GetAbleInterface
{

    /**
     * @param Request $request
     * @param array $params
     *
     * @return JSendResponse
     */
    public function handleGet(Request $request, array $params)
    {
        $allNewsitems = $this->getNewsitemRepository()->getAll();

        /** @var RepresentationFactory $representationFactory */
        $representationFactory = $this->serviceLocator->getRepresentationFactory();

        return $representationFactory->createNewsitemIndexRepresentation($allNewsitems);
    }
}
