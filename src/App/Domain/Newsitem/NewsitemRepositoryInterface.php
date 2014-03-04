<?php

namespace App\Domain\Newsitem;

/**
 * NewsitemRepositoryInterface
 */
interface NewsitemRepositoryInterface
{

    /**
     * @param NewsitemId $id
     * @return Newsitem|null
     */
    public function findOneById(NewsitemId $id);

    /**
     * @return array
     */
    public function getAll();
}
