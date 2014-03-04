<?php

namespace App\Representation\Newsitem;

use App\Domain\Newsitem\Newsitem;
use App\RepresentationFactory;
use Doctrine\ORM\EntityManagerInterface;
use Gn\Api\Representation;
use Gn\Api\Request;
use Gn\Api\Router;
use Gn\Api\ServiceLocator\RepresentationServiceLocator;

/**
 * Index
 */
class IndexRepresentation extends Representation
{

    /**
     * @var array
     */
    protected $newitems;

    /**
     * @param RepresentationServiceLocator $serviceLocator
     * @param array $newsitems
     */
    public function __construct(RepresentationServiceLocator $serviceLocator, array $newsitems)
    {
        $this->newsitems = $newsitems;

        parent::__construct($serviceLocator);
    }

    /**
     * @return array
     */
    protected function configureData()
    {
        $out = array();

        foreach ($this->newsitems as $newsitem) {
            /** @var Newsitem $newsitem */

            $out[] = array(
                'id' => $newsitem->getId()->getValue()
            );
        }

        return $out;
    }
}
