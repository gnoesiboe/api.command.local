<?php

namespace App\Controller;

use Gn\Api\Controller;
use App\Domain\Newsitem\NewsitemRepositoryInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Newsitems
 */
abstract class Newsitem extends Controller
{

    /**
     * @return NewsitemRepositoryInterface
     */
    protected function getNewsitemRepository()
    {
        return $this->serviceLocator->getEntityManager()->getRepository('App\Domain\Newsitem\Newsitem');
    }

    /**
     * @param \App\Domain\Newsitem\Newsitem $newsitem
     * @throws ResourceNotFoundException
     */
    protected function validateNewsitem($newsitem)
    {
        if (($newsitem instanceof \App\Domain\Newsitem\Newsitem) === false) {
            throw new ResourceNotFoundException('No newsitem found with the supplied id');
        }
    }
}
