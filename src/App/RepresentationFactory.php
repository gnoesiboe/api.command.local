<?php

namespace App;

use App\Domain\Category\Category;
use App\Domain\Newsitem\Newsitem;
use App\Representation;

/**
 * RepresentationFactory
 */
class RepresentationFactory extends \Gn\Api\RepresentationFactory
{

    /**
     * @param Newsitem $newsitem
     * @return Representation\Newsitem\DetailRepresentation
     */
    public function createNewsitemDetailRepresentation(Newsitem $newsitem)
    {
        return new Representation\Newsitem\DetailRepresentation(
            $this->representationServiceLocator,
            $newsitem
        );
    }

    /**
     * @param Category $category
     * @return Representation\Category\DetailRepresentation
     */
    public function createCategoryDetailRepresentation(Category $category)
    {
        return new Representation\Category\DetailRepresentation(
            $this->representationServiceLocator,
            $category
        );
    }

    /**
     * @param array $categories
     * @return Representation\Category\DetailRepresentation
     */
    public function createCategoryIndexRepresentation(array $categories)
    {
        return new Representation\Category\IndexRepresentation(
            $this->representationServiceLocator,
            $categories
        );
    }

    /**
     * @param array $newsitems
     * @return Representation\Newsitem\IndexRepresentation
     */
    public function createNewsitemIndexRepresentation(array $newsitems)
    {
        return new Representation\Newsitem\IndexRepresentation(
            $this->representationServiceLocator,
            $newsitems
        );
    }
}
