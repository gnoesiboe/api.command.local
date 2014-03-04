<?php

namespace App\Controller\Category;

use App\Controller\Category;
use App\RepresentationFactory;
use Gn\Api\GetAbleInterface;
use Gn\Api\RepresentationInterface;
use Gn\Api\Request;

/**
 * IndexController
 */
class IndexController extends Category implements GetAbleInterface
{
    /**
     * @param Request $request
     * @param array $params
     *
     * @return RepresentationInterface
     */
    public function handleGet(Request $request, array $params)
    {
        $categories = $this->getCategoryRepository()->getAll();

        /** @var RepresentationFactory $representationFactory */
        $representationFactory = $this->serviceLocator->getRepresentationFactory();

        return $representationFactory->createCategoryIndexRepresentation($categories);
    }
}
