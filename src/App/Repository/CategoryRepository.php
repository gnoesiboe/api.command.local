<?php

namespace App\Repository;

use App\Domain\Category\CategoryId;
use App\Domain\Category\CategoryRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Category
 */
class CategoryRepository extends EntityRepository implements CategoryRepositoryInterface
{

    /**
     * @param CategoryId $id
     * @return mixed
     */
    public function getOneById(CategoryId $id)
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
