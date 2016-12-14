<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 14/12/16
 * Time: 2:37
 */

namespace Jimmy\fifo\Domain\Repository;

use Doctrine\ORM\EntityRepository;
use Jimmy\fifo\Domain\Contracts\Repository\CategoryRepositoryInterface;
use Jimmy\fifo\Domain\Entity\Category;

class DoctrineCategoryRepository extends EntityRepository implements CategoryRepositoryInterface
{

    /**
     * @param $id
     * @return Category
     */
    public function findById($id)
    {
        return $this->find($id);
    }
}