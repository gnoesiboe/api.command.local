<?php

namespace App\Command;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryId;
use App\Domain\Category\CategoryRepositoryInterface;
use App\Domain\Newsitem\Newsitem;
use App\Domain\Newsitem\NewsitemDescription;
use App\Domain\Newsitem\NewsitemTitle;
use Gn\Api\Command;

/**
 * CreateNewsletterCommand
 */
class CreateNewsitemCommand extends Command
{

    /**
     * Configures this command
     */
    protected function configure()
    {
        $this
            ->registerParam('category_id', true)
            ->registerParam('title', true)
            ->registerParam('description', false)
        ;
    }

    /**
     * @param array $params
     * @throws \UnexpectedValueException
     *
     * @return Newsitem
     */
    protected function doApply(array $params)
    {
        $entityManager = $this->serviceLocator->getEntityManager();

        /** @var CategoryRepositoryInterface $categoryRepository */
        $categoryRepository = $entityManager->getRepository('App\Domain\Category\Category');

        $category = $categoryRepository->getOneById(new CategoryId((int) $params['category_id']));

        if (($category instanceof Category) === false) {
            throw new \UnexpectedValueException('The supplied category_id does not match an existing category');
        }

        $newsitem = new Newsitem(new NewsitemTitle($params['title']), $category);
        
        if (array_key_exists('description', $params) === true) {
            $newsitem->setDescription(new NewsitemDescription($params['description']));
        }

        $entityManager->persist($newsitem);
        $entityManager->flush();

        return $newsitem;
    }
}
