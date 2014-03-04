<?php

namespace App\Controller;

use Gn\Api\Controller;
use App\Domain\Category\CategoryRepositoryInterface;

/**
 * Categories
 */
abstract class Category extends Controller
{

    /**
     * @return CategoryRepositoryInterface
     */
    public function getCategoryRepository()
    {
        return $this->serviceLocator->getEntityManager()->getRepository('App\Domain\Category\Category');
    }
}
