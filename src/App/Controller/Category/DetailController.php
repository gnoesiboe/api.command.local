<?php

namespace App\Controller\Category;

use App\Controller;
use App\Domain\Category\CategoryId;
use App\Domain\Category\Category;
use App\Representation\Category\DetailRepresentation;
use App\RepresentationFactory;
use Gn\Api\GetAbleInterface;
use Gn\Api\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * DetailController
 */
class DetailController extends Controller\Category implements GetAbleInterface
{
    /**
     * @param Request $request
     * @param array $params
     *
     * @return DetailRepresentation
     *
     * @throws ResourceNotFoundException
     */
    public function handleGet(Request $request, array $params)
    {
        $categoryId = (int) $params['id'];
        $category = $this->getCategoryRepository()->getOneById(new CategoryId($categoryId));

        if (($category instanceof Category) === false) {
            throw new ResourceNotFoundException('No category found with id: ' . $categoryId);
        }

        /** @var RepresentationFactory $representation */
        $representation = $this->serviceLocator->getRepresentationFactory();

        return $representation->createCategoryDetailRepresentation($category);
    }
}
