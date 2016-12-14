<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 14/12/16
 * Time: 2:36
 */

namespace Jimmy\fifo\Domain\Contracts\Repository;


use Jimmy\fifo\Domain\Entity\Category;

interface CategoryRepositoryInterface
{
    /**
     * @param $id
     * @return Category
     */
    public function findById($id);
}