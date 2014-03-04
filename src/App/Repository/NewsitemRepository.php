<?php

namespace App\Repository;

use App\Domain\Newsitem\NewsitemId;
use App\Domain\Newsitem\NewsitemRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Newsitem
 */
class NewsitemRepository extends EntityRepository implements NewsitemRepositoryInterface
{

    /**
     * @param NewsitemId $id
     * @return NewsitemRepository|null
     */
    public function findOneById(NewsitemId $id)
    {
        return $this->find($id->getValue());
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->findAll();
    }
}
