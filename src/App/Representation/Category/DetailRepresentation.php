<?php

namespace App\Representation\Category;

use App\Domain\Category\Category;
use Doctrine\ORM\EntityManager;
use Gn\Api\Domain\Permission\PermissionIdentifier;
use Gn\Api\Representation;
use Gn\Api\Request;
use Gn\Api\Route;
use Gn\Api\Router;
use Gn\Api\ServiceLocator\RepresentationServiceLocator;

/**
 * Detail
 */
class DetailRepresentation extends Representation
{

    /**
     * @var Category
     */
    protected $category;

    /**
     * @param RepresentationServiceLocator $serviceLocator
     * @param Category $category
     */
    public function __construct(RepresentationServiceLocator $serviceLocator, Category $category)
    {
        $this->category = $category;

        parent::__construct($serviceLocator);
    }

    /**
     * @inheritdoc
     * @return array
     */
    protected function configureData()
    {
        $category = $this->category;

        return array(
            'id'            => $category->getId()->getValue(),
            'title'         => $category->getTitle()->getValue(),
            'created_at'    => $category->getCreatedAt()->format('r'),
            'updated_at'    => $category->getUpdatedAt()->format('r')
        );
    }
}
