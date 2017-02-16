<?php
/**
 * Created by PhpStorm.
 * User: jowy
 * Date: 16/02/17
 * Time: 22:11
 */

namespace Jimmy\fifo\Domain\Repository;


use Doctrine\ORM\EntityRepository;
use Jimmy\fifo\Domain\Contracts\Repository\FooterRepositoryInterface;
use Jimmy\fifo\Domain\Entity\Footer;

class DoctrineFooterRepository extends EntityRepository implements FooterRepositoryInterface
{

    /**
     * @param $id
     * @return Footer
     */
    public function findById($id)
    {
        return $this->find($id);
    }
}