<?php

namespace App\Representation\Newsitem;

use App\Domain\Category\CategoryId;
use App\Domain\Newsitem\Newsitem;
use Doctrine\ORM\EntityManagerInterface;
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
     * @var Newsitem
     */
    protected $newsitem;

    /**
     * @param RepresentationServiceLocator $serviceLocator
     * @param Newsitem $newsitem
     */
    public function __construct(RepresentationServiceLocator $serviceLocator, Newsitem $newsitem)
    {
        $this->newsitem = $newsitem;

        parent::__construct($serviceLocator);
    }

    /**
     * @return array
     */
    protected function configureData()
    {
        $newsitem = $this->newsitem;

        $out = array();

        $out[] = array(
            'id'            => $newsitem->getId()->getValue(),
            'title'         => $newsitem->getTitle()->getValue(),
            'description'   => $newsitem->hasDescription() === true ? $newsitem->getDescription()->getValue() : null,
            'created_at'    => $newsitem->getCreatedAt()->format('r'),
            'updated_at'    => $newsitem->getUpdatedAt()->format('r')
        );

        return $out;
    }
}
