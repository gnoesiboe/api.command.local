<?php

namespace App\Controller\Newsitem;

use App\Domain\Newsitem\Newsitem;
use App\Controller;
use App\Domain\Newsitem\NewsitemId;
use App\RepresentationFactory;
use Gn\Api\GetAbleInterface;
use App\Representation\Newsitem\DetailRepresentation AS DetailRepresentation;
use Gn\Api\Response\Json\JSendResponse;
use Gn\Api\Response\Json\JSendSuccessResponse;
use Gn\Api\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Detail
 */
class DetailController extends Controller\Newsitem implements GetAbleInterface
{

    /**
     * @param Request $request
     * @param array $params
     *
     * @throws ResourceNotFoundException
     *
     * @return JSendResponse
     */
    public function handleGet(Request $request, array $params)
    {
        $newsitemId = new NewsitemId((int) $params['id']);

        $newsitem = $this->getNewsitemRepository()->findOneById($newsitemId);
        $this->validateNewsitem($newsitem);

        /** @var RepresentationFactory $representationFactory */
        $representationFactory = $this->serviceLocator->getRepresentationFactory();
        return $representationFactory->createNewsitemDetailRepresentation($newsitem);
    }

    /**
     * @return array
     */
    public static function getMetaData()
    {
        return array();
    }
}
