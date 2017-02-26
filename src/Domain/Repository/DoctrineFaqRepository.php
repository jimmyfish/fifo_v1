<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 26/02/17
 * Time: 16:15
 */

namespace Jimmy\fifo\Domain\Repository;


use Doctrine\ORM\EntityRepository;
use Jimmy\fifo\Domain\Contracts\Repository\FaqRepositoryInterface;
use Jimmy\fifo\Domain\Entity\Faq;

class DoctrineFaqRepository extends EntityRepository implements FaqRepositoryInterface
{
    /**
     * @param $id
     * @return Faq
     */
    public function findById($id)
    {
        return $this->find($id);
    }
}