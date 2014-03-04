<?php

namespace App\Representation\Category;

use App\Domain\Category\Category;
use Gn\Api\Representation;
use Gn\Api\ServiceLocator\RepresentationServiceLocator;

/**
 * IndexRepresentation
 */
class IndexRepresentation extends Representation
{

    /**
     * @var array
     */
    protected $categories;

    /**
     * @param RepresentationServiceLocator $serviceLocator
     * @param array $categories
     */
    public function __construct(RepresentationServiceLocator $serviceLocator, array $categories)
    {
        $this->categories = $categories;

        parent::__construct($serviceLocator);
    }

    /**
     * @return array
     */
    protected function configureData()
    {
        $out = array();

        foreach ($this->categories as $category) {
            /** @var Category $category */

            $out[] = array(
                'id' => $category->getId()->getValue()
            );
        }

        return $out;
    }
}
