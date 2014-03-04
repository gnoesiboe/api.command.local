<?php

namespace App\Domain\Category;

/**
 * CategoryRepositoryInterface
 */
interface CategoryRepositoryInterface
{

    /**
     * @return array
     */
    public function getAll();

    /**
     * @param CategoryId $id
     * @return Category
     */
    public function getOneById(CategoryId $id);
}
