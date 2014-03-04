<?php

namespace App\Controller\Newsitem;

use App\Command\CreateNewsitemCommand;
use App\Controller\Newsitem;
use App\Representation\Newsitem\DetailRepresentation;
use Gn\Api\PostAbleInterface;
use Gn\Api\Request;
use Gn\Api\Response\Json\JSendResponse;
use Gn\Api\Response\Json\JSendSuccessResponse;

/**
 * CreateNewsitem
 */
class CreateNewsitemController extends Newsitem implements PostAbleInterface
{

    /**
     * @param Request $request
     * @param array $params
     *
     * @return JSendResponse
     */
    public function handlePost(Request $request, array $params)
    {
        $command = new CreateNewsitemCommand($this->serviceLocator->getCommandServiceLocator());
        $newsitem = $command->execute($request->request->all());

        $newsitemDetailRepresentation = new DetailRepresentation(
            $this->serviceLocator->getEntityManager(),
            $request,
            $this->serviceLocator->getRouter(),
            $newsitem
        );

        return new JSendSuccessResponse(201, $newsitemDetailRepresentation);
    }
}
